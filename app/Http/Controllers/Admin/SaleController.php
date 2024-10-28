<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Component;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Estimate;
use App\Models\Executive;
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
        // $sales = Sale::orderBy('id','desc')->paginate(Utility::PAGINATE_COUNT);
        $status_req = request('status');
        $status = isset($status_req)? decrypt($status_req) : 0;

        $sales = Sale::orderBy('sales.id','desc')
        ->leftJoin('estimates','sales.estimate_id','=','estimates.id')
        ->where('estimates.branch_id',default_branch()->id)
        ->where('sales.status',$status)
        ->select('sales.*')->distinct()
        ->paginate(Utility::PAGINATE_COUNT);
        return view('admin.sales.index',compact('sales','status'));
    }

    public function show($id)
    {
        $sale = Sale::findOrFail(decrypt($id));
        $executives = Executive::where('branch_id',default_branch()->id)->where('status',Utility::ITEM_ACTIVE)->get();

        // $sub_total = Sale::with('products')
        //     ->join('product_sale', 'sales.id', '=', 'product_sale.sale_id')
        //     ->selectRaw('SUM(product_sale.price * product_sale.quantity) as total')
        //     ->where('sale_id',decrypt($id))
        //     ->first()
        //     ->total; // this is right code, But done an easy way in Sale Model for sub_total

        return view('admin.sales.view',compact('sale','executives'));
    }

    public function view_invoice($id) {
        $sale = Sale::findOrFail(decrypt($id));
        // return view('admin.sales.pdf',compact('data'));
        $pdf = Pdf::loadView('admin.sales.pdf', compact('sale'))->setPaper('a4', 'portrait');
        return $pdf->stream($sale->invoice_no.'_' . date('YmdHis') . '.pdf');
    }

    public function download_invoice($id) {
        $sale = Sale::findOrFail(decrypt($id));
        // return view('admin.sales.pdf',compact('data'));
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

    public function addDiscount() {
        $id = request('sale_id');
        $round_off = request('round_off');
        $sale = Sale::find(decrypt($id));
        $sale->update(['round_off'=>$round_off]);
        return $sale;
    }

    public function changeStatus($id, $status) {
        $sale = Sale::find(decrypt($id));
        $status = decrypt($status);
        $sale->update(['status'=>$status]);
        // return redirect()->route('admin.customers.index')->with(['success'=>'Status changed Successfully']);
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
