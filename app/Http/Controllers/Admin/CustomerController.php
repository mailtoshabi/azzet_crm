<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\ContactPerson;
use App\Models\Customer;
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
        $customers = Customer::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.customers.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = DB::table('states')->select('id','name')->get();
        return view('admin.customers.add',compact('states'));
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
            'email' => 'nullable|email|unique:customers,email',
            'phone' => 'required|string|max:10|min:10|unique:customers,phone',
        ]);
        $input = request()->except(['_token','image']);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = Utility::cleanString(request()->name) . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('customers', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
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
        return view('admin.customers.view',compact('customer'));
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
        $states = DB::table('states')->select('id','name')->get();
        return view('admin.customers.add',compact('customer','states'));
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
            'email' => 'required|email|unique:customers,email,'. $id,
            'phone' => 'required|string|max:10|min:10|unique:customers,phone,'. $id,

        ]);
        $input = request()->except(['_token','_method','image']);
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
        if(!empty($customer->image)) {
            Storage::delete(Customer::DIR_PUBLIC . $customer->image);
            $input['image'] =null;
        }
        $customer->delete();
        return redirect()->route('admin.customers.index')->with(['success'=>'Customer Deleted Successfully']);
    }

    public function changeStatus($id) {
        $customer = Customer::find(decrypt($id));
        $currentStatus = $customer->status;
        $status = $currentStatus ? 0 : 1;
        $customer->update(['status'=>$status]);
        return redirect()->route('admin.customers.index')->with(['success'=>'Status changed Successfully']);
    }

    public function distric_list(Request $request) {

        // $customer_id = Auth::guard('customer')->user()->id;
        // $customerDetails = CustomerDetail::where('customer_id',$customer_id)->first();
        // $customer_district_id = !empty($customerDetails->address)?$customerDetails->address['district']:'';

        $districts = DB::table('districts')->select('id','name')->where('state_id',$request->state_id)->get();
        $data[]= '<option value="">Select District</option>';
        foreach($districts as $district) {
            // $selected = !empty($customer_district_id) && ($district->id == $customer_district_id) ? 'selected' : '';
            $selected = '';
            $data[] = '<option value="' . $district->id . '"' . $selected . ' >'. $district->name . '</option>';
        }
        return $data;
    }

}
