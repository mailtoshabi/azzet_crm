<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Component;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Estimate;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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
            ->join('estimates','sales.estimate_id','=','estimates.id')
            ->join('customers','estimates.customer_id','=','customers.id')
            ->join('employees','customers.employee_id','=','employees.id')
            ->where('employees.id',Auth::guard('employee')->id())
            ->distinct()->paginate(Utility::PAGINATE_COUNT);
        }else {
            $sales = Sale::orderBy('sales.id','desc')
            ->join('estimates','sales.estimate_id','=','estimates.id')
            ->join('customers','estimates.customer_id','=','customers.id')
            ->join('employees','customers.employee_id','=','employees.id')
            ->where('employees.id',Auth::guard('employee')->id())
            ->where('sales.status',$status)
            ->select('sales.*')->distinct()
            ->paginate(Utility::PAGINATE_COUNT);
        }
        return view('admin.employee.sales.index',compact('sales','status'));
    }

    public function show($id)
    {
        $sale = Sale::findOrFail(decrypt($id));
        if(isset($sale->estimate->customer->employee)&&($sale->estimate->customer->employee->id == Auth::guard('employee')->id())) {
            return view('admin.employee.sales.view',compact('sale'));
        }else{
            abort(404);
        }
    }

    public function view_invoice($id) {
        $sale = Sale::findOrFail(decrypt($id));
        if($sale->estimate->customer->employee->id == Auth::guard('employee')->id()) {
            $pdf = Pdf::loadView('admin.employee.sales.pdf', compact('sale'))->setPaper('a4', 'portrait');
            return $pdf->stream($sale->invoice_no.'_' . date('YmdHis') . '.pdf');
        }else{
            abort(404);
        }
    }

    public function download_invoice($id) {
        $sale = Sale::findOrFail(decrypt($id));
        if($sale->estimate->customer->employee->id == Auth::guard('employee')->id()) {
        $pdf = Pdf::loadView('admin.employee.sales.pdf', compact('sale'))->setPaper('a4', 'portrait');
        return $pdf->download($sale->invoice_no.'_' . date('YmdHis') . '.pdf');
        }else{
            abort(404);
        }
    }

    public function changeStatus($id, $status) {
        $sale = Sale::find(decrypt($id));
        $status = decrypt($status);
        if($status<=Utility::STATUS_DELIVERED) {
            $sale->update(['status'=>$status]);
            return $sale;
        }
    }

}
