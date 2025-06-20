<?php

namespace App\Http\Controllers\Employee;

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
        $auth_id = Auth::guard('employee')->id();
        $status = request('status');
        $count_pending = Enquiry::where('is_approved',Utility::ITEM_INACTIVE)->where('employee_id',$auth_id)->count();
        $is_approved = isset($status)? decrypt(request('status')) : ($count_pending==0?1:0);
        $count_new = $count_pending<99? $count_pending:'99+';
        $enquiries = Enquiry::orderBy('id','desc')->where('is_approved',$is_approved)->where('employee_id',$auth_id)->paginate(Utility::PAGINATE_COUNT);
        return view('admin.employee.enquiries.index',compact('enquiries','is_approved','count_new'));
    }

    public function create() {
        $authId = Auth::guard('employee')->id();
        $customers = Customer::where('employee_id',$authId)->get(); //where('status',Utility::ITEM_ACTIVE)->
        // $products = Product::all(); //where('status',Utility::ITEM_ACTIVE)->get()

        $products = Product::where(function ($query) use ($authId) {
            // Condition 1: employee_id is not the auth user and status is active
            // $query->where('employee_id', '!=', $authId)

            $query->where(function ($query) use ($authId) {
                $query->where('employee_id', '!=', $authId)
                ->orWhere('employee_id', null);
            })
                  ->where('status', 1);
        })
        ->orWhere(function ($query) use ($authId) {
            // Condition 2: employee_id is the auth user
            $query->where('employee_id', $authId);
        })
        ->get();

        return view('admin.employee.enquiries.add',compact('customers','products'));
    }

    public function store () {
        // return request()->all();
        $validated = request()->validate([
            'customer_id' => 'required',
        ]);
        $input = request()->only(['customer_id','description']);
        $input['employee_id'] = Auth::guard('employee')->id();

        $branch_id = Auth::guard('employee')->user()->branch_id;
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

        return redirect()->route('employee.enquiries.index')->with(['success'=>'New Enquiry Added Successfully']);
    }

    public function edit($id) {
        $enquiry = Enquiry::findOrFail(decrypt($id));
        if(!$enquiry->is_approved) {
        $auth_id = Auth::guard('employee')->id();
        $customers = Customer::where('status',Utility::ITEM_ACTIVE)->where('employee_id',$auth_id)->get();
        $products = Product::where('status',Utility::ITEM_ACTIVE)->get();
        return view('admin.employee.enquiries.add',compact('customers','products','enquiry'));
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
        $input = request()->only(['customer_id','description']);
        // $input['employee_id'] =Auth::guard('employee')->id();
        $enquiry->update($input);
        $enquiry->products()->detach();
        if(!empty(request('products'))) {
            foreach(request('products') as $index => $product_id) {
                if(!empty($product_id)) {
                    $enquiry->products()->attach($product_id, ['quantity' => request('quantities')[$index]]);
                }
            }
        }
        return redirect()->route('employee.enquiries.index')->with(['success'=>'Enquiry Updated Successfully']);
    }else {
        abort(404);
    }
    }

    public function destroy($id) {
        $enquiry = Enquiry::find(decrypt($id));
        if(!$enquiry->is_approved) {
        $enquiry->delete();
        return redirect()->route('employee.enquiries.index')->with(['success'=>'Enquiry Deleted Successfully']);
        }else {
            abort(404);
        }
    }


}
