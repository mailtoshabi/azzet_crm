<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Component;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Estimate;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index() {
        $status_req = request('status');
        $status = isset($status_req)? decrypt($status_req) : 0;

        if($status==Utility::STATUS_NOTPAID) {
            $sales = Sale::with('payments')
                    ->addSelect([
                        'total_paid' => Payment::select(DB::raw('COALESCE(SUM(amount), 0)'))
                            ->whereColumn('sale_id', 'sales.id')
                            ->where('status', Utility::PAYMENT_COMPLETED)
                    ])
                    ->addSelect([
                        'sub_total' => DB::table('product_sale')
                            ->join('products', 'product_sale.product_id', '=', 'products.id')
                            ->join('hsns', 'products.hsn_id', '=', 'hsns.id')
                            ->join('tax_slabs', 'hsns.tax_slab_id', '=', 'tax_slabs.id')
                            ->select(DB::raw('SUM(product_sale.price * product_sale.quantity) + SUM((product_sale.price * product_sale.quantity) * (tax_slabs.name_tax / 100)) + (sales.delivery_charge) - (sales.round_off) - (sales.discount)'))
                            ->whereColumn('sale_id', 'sales.id')
                    ])
                    ->havingRaw('total_paid < sub_total')
                    ->leftJoin('estimates','sales.estimate_id','=','estimates.id')
                    ->where('estimates.branch_id',default_branch()->id)
                    ->distinct()->paginate(Utility::PAGINATE_COUNT);
        }else {
        $sales = Sale::orderBy('sales.id','desc')
                ->join("estimates",function($join){
                    $join->on("estimates.id","=","sales.estimate_id")
                    ->where('estimates.branch_id',default_branch()->id);
                    })

                ->join("sale_statuses",function($join) use ($status) {
                    $join->on("sale_statuses.sale_id","=","sales.id")
                    ->where('sale_statuses.status',$status)
                    ->where('sale_statuses.is_current',Utility::ITEM_ACTIVE);
                    })

                // ->leftJoin('estimates','sales.estimate_id','=','estimates.id')
                // ->where('estimates.branch_id',default_branch()->id)

                ->select('sales.*')->distinct()
                ->paginate(Utility::PAGINATE_COUNT);
        }
        return view('admin.sales.index',compact('sales','status'));
    }

    public function show($id)
    {
        $sale = Sale::findOrFail(decrypt($id));
        // return $sale->status;
        if ($sale->estimate->branch_id !== default_branch()->id) {
            abort(403, 'This estimate is not associated with this branch.');
        }
        $employees = Employee::where('branch_id',default_branch()->id)->where('status',Utility::ITEM_ACTIVE)->get();
        $payment_edit_id = request('payment_edit_id');
        if(isset($payment_edit_id)) {
            $payment_edit = Payment::find(decrypt($payment_edit_id));
        }else {
            $payment_edit = null;
        }

        return view('admin.sales.view',compact('sale','employees','payment_edit'));
    }

    public function edit($id) {
        $sale = Sale::findOrFail(decrypt($id));
        if($sale->status==Utility::STATUS_CLOSED) {
            abort(403, 'The Proforma has already been closed');
        }
        if ($sale->estimate->branch_id !== default_branch()->id) {
            abort(403, 'This estimate is not associated with this branch.');
        }
        $estimate_id = $sale->estimate->id;
        $estimate = Estimate::findOrFail($estimate_id);
        // if(!$estimate->sale) {
        foreach($estimate->products as $estimate_product) {
            $estimate_product_comps = DB::table('component_estimate_product')->where('estimate_product_id',$estimate_product->pivot->id)->get();
            $estimate_product->components = $estimate_product_comps;
        }
        $customers = Customer::where('status',Utility::ITEM_ACTIVE)->where('branch_id',default_branch()->id)->orderBy('id','desc')->get();
        $products = Product::where('status',Utility::ITEM_ACTIVE)->orderBy('id','desc')->get();
        $components = Component::where('status',Utility::ITEM_ACTIVE)->orderBy('id','asc')->get();
        return view('admin.sales.edit',compact('customers','products','estimate','components'));
    }

    public function update () {
        $id = decrypt(request('estimate_id'));
        $estimate = Estimate::find($id);
        $sale = Sale::find($estimate->sale->id);
        if($sale->status==Utility::STATUS_CLOSED) {
            abort(403, 'The Proforma has already been closed');
        }
        if ($estimate->branch_id !== default_branch()->id) {
            abort(403, 'This estimate is not associated with this branch.');
        }
        $validated = request()->validate([
            'customer_id' => 'required',
        ]);
        $input = request()->only(['customer_id']);

        $input['user_id'] =Auth::id();
        $estimate->update($input);
        $estimate->products()->detach();
        if(!empty(request('products'))) {
            foreach(request('products') as $index => $product_id) {
                if(!empty($product_id)) {
                    $data = ['estimate_id' => $estimate->id, 'product_id' => $product_id, 'quantity' => request('quantities')[$index],'profit' => request('profits')[$index],'created_at' => now(),'updated_at' => now()];
                    $estimate_product = DB::table('estimate_product')->insert($data);

                    $lastInsertedId = DB::getPdo()->lastInsertId();
                    foreach(request('component_names')[$index] as $index_comp => $component_id) {
                        if(!empty($component_id)) {
                            $data_comp = ['estimate_product_id' => $lastInsertedId, 'component_id' => $component_id, 'cost' => request('costs')[$index][$index_comp],'o_cost' => request('o_costs')[$index][$index_comp],'created_at' => now(),'updated_at' => now()];
                            $estimate_product_comp = DB::table('component_estimate_product')->insert($data_comp);
                        }
                    }
                }
            }
        }

        $sale->products()->detach();
        foreach($estimate->products as $estimate_product) {
            $profit = $estimate_product->pivot->profit;
            $quantity = $estimate_product->pivot->quantity;
            $sum_price_components = DB::table('component_estimate_product')->where('estimate_product_id',$estimate_product->pivot->id)->sum('cost');
            $price = $profit + $sum_price_components;
            $input_product_sale = ['sale_id'=>$sale->id,'product_id'=>$estimate_product->id,'price'=>$price,'quantity'=>$quantity];
            DB::table('product_sale')->insert($input_product_sale);
        }

        return redirect()->route('admin.sales.view',encrypt($sale->id))->with(['success'=>'Estimate & Proforma Updated Successfully']);
    }

    public function view_invoice($id) {
        $sale = Sale::findOrFail(decrypt($id));
        $pdf = Pdf::loadView('admin.sales.pdf', compact('sale'))->setPaper('a4', 'portrait');
        return $pdf->stream($sale->invoice_no.'_' . date('YmdHis') . '.pdf');
    }

    public function download_invoice($id) {
        $sale = Sale::findOrFail(decrypt($id));
        $pdf = Pdf::loadView('admin.sales.pdf', compact('sale'))->setPaper('a4', 'portrait');

        return $pdf->download($sale->invoice_no.'_' . date('YmdHis') . '.pdf');
    }

    public function addFreight() {
        $id = request('sale_id');
        // return request()->all();
        $delivery_charge = request('delivery_charge');
        $sale = Sale::find(decrypt($id));
        if($sale->status==Utility::STATUS_CLOSED) {
            abort(403, 'The Proforma has already been closed');
        }
        $sale->update(['delivery_charge'=>$delivery_charge]);
        return $sale;
    }

    public function addRoundOff() {
        $id = request('sale_id');
        $round_off = request('round_off');
        $sale = Sale::find(decrypt($id));
        if($sale->status==Utility::STATUS_CLOSED) {
            abort(403, 'The Proforma has already been closed');
        }
        $sale->update(['round_off'=>$round_off]);
        return $sale;
    }

    public function addDiscount() {
        $id = request('sale_id');
        $discount = request('discount');
        $sale = Sale::find(decrypt($id));
        if($sale->status==Utility::STATUS_CLOSED) {
            abort(403, 'The Proforma has already been closed');
        }
        $sale->update(['discount'=>$discount]);
        return $sale;
    }

    public function changeStatus() {
        $sale_id = request('sale_id_s');
        $status_id = request('status_id_s');
        $sale = Sale::find(decrypt($sale_id));
        $status_id = decrypt($status_id);
//TODO: Only can change status to close if the payment has fully paid.
        $sale_status_update = DB::table('sale_statuses')->where('sale_id',decrypt($sale_id))->where('is_current',Utility::ITEM_ACTIVE)->update(['is_current' => Utility::ITEM_INACTIVE]);
        // foreach($sale_status_updates as $sale_status_update) {
        //     $sale_status_update->update(['is_current' => Utility::ITEM_INACTIVE]);
        // }
        $sale_status_insert = DB::table('sale_statuses')->insert([
            'sale_id' => decrypt($sale_id),
            'status' => $status_id,
            'description' => request('description_s'),
            'is_current' => Utility::ITEM_ACTIVE,
            'user_id' => Auth::id()
        ]);
        return $sale;
    }

    // public function addEmployee() {
    //     $id = request('sale_id');
    //     $employee_id = request('employee_id');
    //     $sale = Sale::find(decrypt($id));
    //     $sale->update(['employee_id'=>$employee_id]);
    //     return $sale;
    // }

}
