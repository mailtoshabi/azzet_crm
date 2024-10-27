<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Branch;
use App\Models\ContactPerson;
use App\Models\Customer;
use App\Models\Executive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $status = request('status');
        $count_pending = Customer::where('is_approved',Utility::ITEM_INACTIVE)->where('branch_id',default_branch()->id)->count();
        // return $count_pending;
        $is_approved = isset($status)? decrypt(request('status')) : ($count_pending==0?1:0);
        $customers = Customer::orderBy('id','desc')->where('branch_id',default_branch()->id)->where('is_approved',$is_approved)->paginate(Utility::PAGINATE_COUNT);
        return view('admin.customers.index',compact('customers','is_approved'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = DB::table('states')->orderBy('name','asc')->select('id','name')->get();
        $banks = DB::table('banks')->where('status',Utility::ITEM_ACTIVE)->orderBy('name','asc')->select('id','name')->get();
        $branches = Branch::where('status',Utility::ITEM_ACTIVE)->orderBy('id','desc')->get();
        return view('admin.customers.add',compact('states','banks','branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // return request('contact_names');
        $validated = request()->validate([
            'name' => 'required',
            // 'email' => 'nullable|email|unique:customers,email',
            'phone' => 'required|string|max:10|min:10|unique:customers,phone',
            'city' => 'required',
            'district_id' => 'required',
            'state_id' => 'required',
        ]);
        $input = request()->except(['_token','image','contact_names','phones','emails']);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = Utility::cleanString(request()->name) . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('customers', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $input['branch_id'] = default_branch()->id;
        $input['is_approved'] = 1;
        $customer = Customer::create($input);

        if(!empty(request('contact_names'))) {
            foreach(request('contact_names') as $index => $contact_name) {
                if(!empty($contact_name)) {
                    // $customer->contactPersons()->attach($customer->id,['name'=>$contact_name,'email'=>request('emails')[$index], 'phone'=>request('phones')[$index]]);
                    $contactPerson = new ContactPerson();
                    $contactPerson->create(['name' => $contact_name, 'email' => request('emails')[$index], 'phone' => request('phones')[$index], 'customer_id' => $customer->id, 'user_id' => Auth::id()]);
                }
            }
        }

        return redirect()->route('admin.customers.index')->with(['success'=>'New Customer Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail(decrypt($id));
        $executives = Executive::where('branch_id',default_branch()->id)->where('status',Utility::ITEM_ACTIVE)->get();
        return view('admin.customers.view',compact('customer','executives'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail(decrypt($id));
        $states = DB::table('states')->orderBy('name','asc')->select('id','name')->get();
        $banks = DB::table('banks')->where('status',Utility::ITEM_ACTIVE)->orderBy('name','asc')->select('id','name')->get();
        $branches = Branch::where('status',Utility::ITEM_ACTIVE)->orderBy('id','desc')->get();
        return view('admin.customers.add',compact('customer','states','banks','branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $id = decrypt(request('customer_id'));
        $customer = Customer::find($id);
        //return Customer::DIR_PUBLIC . $customer->image;
        $validated = request()->validate([
            'name' => 'required',
            // 'email' => 'nullable|email|unique:customers,email,'. $id,
            'phone' => 'required|string|max:10|min:10|unique:customers,phone,'. $id,
            'city' => 'required',
            'district_id' => 'required',
            'state_id' => 'required',
            'branch_id' => 'required',
        ]);
        $input = request()->except(['_token','_method','customer_id','image','contact_names','phones','emails']);
        if(request('isImageDelete')==1) {
            Storage::delete(Customer::DIR_PUBLIC . $customer->image);
            $input['image'] =null;
        }
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = Utility::cleanString(request()->name) . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('customers', $fileName);
            $input['image'] =$fileName;
        }
        //$input['user_id'] =Auth::id();
        $input['is_approved'] = 1;
        $customer->update($input);
        $contactPersons = ContactPerson::where('customer_id',$customer->id)->get();
        if(!empty($contactPersons)) {
           foreach($contactPersons as $contactPerson_d)
            $contactPerson_d->delete();
        }
        if(!empty(request('contact_names'))) {
            foreach(request('contact_names') as $index => $contact_name) {
                if(!empty($contact_name)) {
                    // $customer->contactPersons()->attach($customer->id,['name'=>$contact_name,'email'=>request('emails')[$index], 'phone'=>request('phones')[$index]]);
                    $contactPerson = new ContactPerson();
                    $contactPerson->create(['name' => $contact_name, 'email' => request('emails')[$index], 'phone' => request('phones')[$index], 'customer_id' => $customer->id, 'user_id' => Auth::id()]);
                }
            }
        }

        return redirect()->route('admin.customers.index')->with(['success'=>'Customer Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find(decrypt($id));
        if(!$customer->is_approved) {
        if(!empty($customer->image)) {
            Storage::delete(Customer::DIR_PUBLIC . $customer->image);
            $input['image'] =null;
        }
        $customer->delete();
        return redirect()->route('admin.customers.index')->with(['success'=>'Customer Deleted Successfully']);
    }else{
        abort(404);
    }
    }

    public function changeStatus($id) {
        $customer = Customer::find(decrypt($id));
        if($customer->is_approved) {
            $currentStatus = $customer->status;
            $status = $currentStatus ? 0 : 1;
            $customer->update(['status'=>$status]);
            return redirect()->route('admin.customers.index')->with(['success'=>'Status changed Successfully']);
        }else{
            abort(404);
        }
    }

    public function approve($id) {
        $customer = Customer::find(decrypt($id));
        if($customer->executive) {
        $currentStatus = $customer->is_approved;
        $status = $currentStatus ? 0 : 1;
        $customer->update(['is_approved'=>$status, 'status'=>$status]);
        $status = encrypt($status);
        return redirect()->route('admin.customers.index','status='.$status)->with(['success'=>'Data Approved Successfully']);
        }else{
            abort(404);
        }
    }

    public function distric_list(Request $request) {
        $districts = DB::table('districts')->orderBy('name','asc')->select('id','name')->where('state_id',$request->s_id)->get();
        $data[]= '<option value="">Select District</option>';
        foreach($districts as $district) {
            $selected = $district->id == $request->d_id ? 'selected' : '';
            $data[] = '<option value="' . $district->id . '"' . $selected . ' >'. $district->name . '</option>';
        }
        return $data;
    }

    public function addExecutive() {
        $id = request('customer_id');
        $executive_id = request('executive_id');
        $customer = Customer::find(decrypt($id));
        $customer->update(['executive_id'=>$executive_id]);
        return $customer;
    }
}
