<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // public function index() {
    //     $payments = Payment::orderBy('id','asc')->paginate(Utility::PAGINATE_COUNT);
    //     return view('admin.payments.index',compact('payments'));
    // }

    // public function create() {
    //     $gst_slabs = TaxSlab::orderBy('id','asc')->where('status',Utility::ITEM_ACTIVE)->get();
    //     return view('admin.payments.add',compact('gst_slabs'));
    // }

    public function store () {
        $validated = request()->validate([
            'amount' => 'required',
            'payment_method' => 'required',
            'paid_at' => 'required',
            'status' => 'required',
        ]);
        // return Carbon::parse(request('paid_at'))->format('Y-m-d');
        $input = request()->only(['amount','payment_method','transaction_id','description','status']);
        $input['sale_id'] = decrypt(request('sale_id'));
        $input['paid_at'] = Carbon::parse(request('paid_at'))->format('Y-m-d');
        $payment = Payment::create($input);
        return redirect()->to(route('admin.sales.view',request('sale_id')).'#allPaymentDetails')->with(['success'=>'New Payment Added Successfully']);
    }

    // public function edit($id) {
    //     $payment = Payment::findOrFail(decrypt($id));
    //     return view('admin.payments.add',compact('payment','gst_slabs'));
    // }

    public function update () {
        $id = decrypt(request('payment_id'));
        $payment = Payment::find($id);
        // return $payment;
        $validated = request()->validate([
            'amount' => 'required',
            'payment_method' => 'required',
            'paid_at' => 'required',
            'status' => 'required',
        ]);
        $input = request()->only(['amount','payment_method','transaction_id','description','status']);
        $input['sale_id'] = decrypt(request('sale_id'));
        $input['paid_at'] = Carbon::parse(request('paid_at'))->format('Y-m-d');
        $payment->update($input);
        // return redirect()->route('admin.payments.index')->with(['success'=>'Payment Updated Successfully']);
        return redirect()->to(route('admin.sales.view',request('sale_id')).'#allPaymentDetails')->with(['success'=>'Payment Updated Successfully']);
    }

    public function destroy($id) {
        $payment = Payment::find(decrypt($id));
        // return request()->all();
        $payment->delete();
        return redirect()->to(route('admin.sales.view',request('sale_id')).'#allPaymentDetails')->with(['success'=>'Payment Deleted Successfully']);
    }
}
