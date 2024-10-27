<?php

namespace App\Http\Controllers\Executive;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Component;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Enquiry;
use App\Models\Estimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EnquiryController extends Controller
{
    public function index() {
        $auth_id = Auth::guard('executive')->id();
        $status = request('status');
        $count_pending = Enquiry::where('is_approved',Utility::ITEM_INACTIVE)->where('executive_id',$auth_id)->count();
        $is_approved = isset($status)? decrypt(request('status')) : ($count_pending==0?1:0);

        $enquiries = Enquiry::orderBy('id','desc')->where('is_approved',$is_approved)->where('executive_id',$auth_id)->paginate(Utility::PAGINATE_COUNT);
        return view('admin.executive.enquiries.index',compact('enquiries','is_approved'));
    }

    public function create() {
        $auth_id = Auth::guard('executive')->id();
        $customers = Customer::where('status',Utility::ITEM_ACTIVE)->where('executive_id',$auth_id)->get();
        $products = Product::where('status',Utility::ITEM_ACTIVE)->get();
        return view('admin.executive.enquiries.add',compact('customers','products'));
    }

    public function store () {
        // return request()->all();
        $validated = request()->validate([
            'customer_id' => 'required',
        ]);
        $input = request()->only(['customer_id']);
        $input['executive_id'] = Auth::guard('executive')->id();

        $branch_id = Auth::guard('executive')->user()->branch_id;
        $input['branch_id'] = $branch_id;
        $input['is_approved'] =0;
        $enquiry = Enquiry::create($input);

        if(!empty(request('products'))) {
            foreach(request('products') as $index => $product_id) {
                if(!empty($product_id)) {
                    $enquiry->products()->attach($product_id, ['quantity' => request('quantities')[$index]]);
                }
            }
        }

        return redirect()->route('executive.enquiries.index')->with(['success'=>'New Enquiry Added Successfully']);
    }

    public function edit($id) {
        $enquiry = Enquiry::findOrFail(decrypt($id));
        if(!$enquiry->is_approved) {
        $auth_id = Auth::guard('executive')->id();
        $customers = Customer::where('status',Utility::ITEM_ACTIVE)->where('executive_id',$auth_id)->get();
        $products = Product::where('status',Utility::ITEM_ACTIVE)->get();
        return view('admin.executive.enquiries.add',compact('customers','products','enquiry'));
        }else {
            abort(404);
        }
    }

    public function update () {
        $estimate = request('estimate');
        $id = decrypt(request('enquiry_id'));
        $comp_customer_id = request('customer_id');
        $enquiry = Enquiry::find($id);
        if(!$enquiry->is_approved) {
        $validated = request()->validate([
            'customer_id' => 'required',
        ]);
        $input = request()->only(['customer_id']);
        // $input['executive_id'] =Auth::guard('executive')->id();
        $enquiry->update($input);
        $enquiry->products()->detach();
        if(!empty(request('products'))) {
            foreach(request('products') as $index => $product_id) {
                if(!empty($product_id)) {
                    $enquiry->products()->attach($product_id, ['quantity' => request('quantities')[$index]]);
                }
            }
        }
        return redirect()->route('executive.enquiries.index')->with(['success'=>'Enquiry Updated Successfully']);
    }else {
        abort(404);
    }
    }

    public function destroy($id) {
        $enquiry = Enquiry::find(decrypt($id));
        if(!$enquiry->is_approved) {
        $enquiry->delete();
        return redirect()->route('executive.enquiries.index')->with(['success'=>'Enquiry Deleted Successfully']);
        }else {
            abort(404);
        }
    }


}
