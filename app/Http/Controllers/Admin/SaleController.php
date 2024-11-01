<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Executive;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
        ->leftJoin('estimates','sales.estimate_id','=','estimates.id')
        ->where('estimates.branch_id',default_branch()->id)
        ->where('sales.status',$status)
        ->select('sales.*')->distinct()
        ->paginate(Utility::PAGINATE_COUNT);
        }
        return view('admin.sales.index',compact('sales','status'));
    }

    public function show($id)
    {
        $sale = Sale::findOrFail(decrypt($id));
        $executives = Executive::where('branch_id',default_branch()->id)->where('status',Utility::ITEM_ACTIVE)->get();
        $payment_edit_id = request('payment_edit_id');
        if(isset($payment_edit_id)) {
            $payment_edit = Payment::find(decrypt($payment_edit_id));
        }else {
            $payment_edit = null;
        }

        return view('admin.sales.view',compact('sale','executives','payment_edit'));
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
        $delivery_charge = request('delivery_charge');
        $sale = Sale::find(decrypt($id));
        $sale->update(['delivery_charge'=>$delivery_charge]);
        return $sale;
    }

    public function addRoundOff() {
        $id = request('sale_id');
        $round_off = request('round_off');
        $sale = Sale::find(decrypt($id));
        $sale->update(['round_off'=>$round_off]);
        return $sale;
    }

    public function addDiscount() {
        $id = request('sale_id');
        $discount = request('discount');
        $sale = Sale::find(decrypt($id));
        $sale->update(['discount'=>$discount]);
        return $sale;
    }

    public function changeStatus($id, $status) {
        $sale = Sale::find(decrypt($id));
        $status = decrypt($status);
        $sale->update(['status'=>$status]);
        return $sale;
    }

    public function addExecutive() {
        $id = request('sale_id');
        $executive_id = request('executive_id');
        $sale = Sale::find(decrypt($id));
        $sale->update(['executive_id'=>$executive_id]);
        return $sale;
    }

}
