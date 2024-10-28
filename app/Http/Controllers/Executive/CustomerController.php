<?php

namespace App\Http\Controllers\Executive;

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
        $auth_id = Auth::guard('executive')->id();
        $status = request('status');
        $is_approved = isset($status)? decrypt(request('status')) : 0;
        $customers = Customer::orderBy('id')->where('is_approved',$is_approved)->where('executive_id',$auth_id)->paginate(Utility::PAGINATE_COUNT);
        return view('admin.executive.customers.index',compact('customers','is_approved'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = DB::table('states')->select('id','name')->get();
        return view('admin.executive.customers.add',compact('states'));
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
            'city' => 'required',
            'district_id' => 'required',
            'state_id' => 'required'
        ]);
        $input = request()->except(['_token','image','contact_names','phones','emails','isImageDelete']);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = Utility::cleanString(request()->name) . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('customers', $fileName);
            $input['image'] =$fileName;
        }
        $input['executive_id'] =Auth::guard('executive')->id();
        $branch_id = Auth::guard('executive')->user()->branch_id;
        $input['branch_id'] = $branch_id;
        $status = 0;
        $input['status'] =$status;
        $customer = Customer::create($input);

        if(!empty(request('contact_names'))) {
            foreach(request('contact_names') as $index => $contact_name) {
                if(!empty($contact_name)) {
                    // $customer->contactPersons()->attach($customer->id,['name'=>$contact_name,'email'=>request('emails')[$index], 'phone'=>request('phones')[$index]]);
                    $contactPerson = new ContactPerson();
                    $contactPerson->create(['name' => $contact_name, 'email' => request('emails')[$index], 'phone' => request('phones')[$index], 'customer_id' => $customer->id, 'user_id' => Auth::guard('executive')->id()]);
                }
            }
        }

        return redirect()->route('executive.customers.index')->with(['success'=>'New Customer Added Successfully']);
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
        return view('admin.executive.customers.view',compact('customer'));
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
        if(!$customer->is_approved) {
        $states = DB::table('states')->select('id','name')->get();
        return view('admin.executive.customers.add',compact('customer','states'));
        }else {
            abort(404);
        }
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
        if(!$customer->is_approved) {
            //return Customer::DIR_PUBLIC . $customer->image;
            $validated = request()->validate([
                'name' => 'required',
                'email' => 'nullable|email|unique:customers,email,'. $id,
                'phone' => 'required|string|max:10|min:10|unique:customers,phone,'. $id,
                'city' => 'required',
                'district_id' => 'required',
                'state_id' => 'required'
            ]);
            $input = request()->except(['_token','_method','customer_id','image','contact_names','phones','emails','isImageDelete']);
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
            //$input['user_id'] =Auth::guard('executive')->id();
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
                        $contactPerson->create(['name' => $contact_name, 'email' => request('emails')[$index], 'phone' => request('phones')[$index], 'customer_id' => $customer->id, 'user_id' => Auth::guard('executive')->id()]);
                    }
                }
            }

            return redirect()->route('executive.customers.index')->with(['success'=>'Customer Updated Successfully']);
    }else {
        abort(404);
    }
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
        return redirect()->route('executive.customers.index')->with(['success'=>'Customer Deleted Successfully']);
    }else{
        abort(404);
    }
    }

    public function distric_list(Request $request) {
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
