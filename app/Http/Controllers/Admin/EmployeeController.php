<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Branch;
use App\Models\Delivery;
use App\Models\Employee;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $employees = Employee::orderBy('id','desc')->where('branch_id',default_branch()->id)->paginate(Utility::PAGINATE_COUNT);
        return view('admin.employees.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::where('status',Utility::ITEM_ACTIVE)->orderBy('id','desc')->get();
        $states = DB::table('states')->orderBy('name','asc')->select('id','name')->get();
        return view('admin.employees.add',compact('branches','states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validated = request()->validate([
            'name' => 'required',
            'email' => 'nullable|email|required_without:phone|unique:employees,email',
            'phone' => 'nullable|regex:/^[0-9]{10}$/|required_without:email|unique:employees,phone',
            'password' => 'required|min:6',
            'postal_code' => 'required',
            'district_id' => 'required',
            'state_id' => 'required',
        ]);
        $input = request()->except(['_token','email_verified_at','password','avatar','user_id']);
        if(request()->hasFile('avatar')) {
            $extension = request('avatar')->extension();
            // $fileName = 'user_pic_' . date('YmdHis') . '.' . $extension;
            $fileName = Utility::cleanString(request()->name) . date('YmdHis') . '.' . $extension;
            request('avatar')->storeAs('employees', $fileName);
            $input['avatar'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $input['branch_id'] = default_branch()->id;
        $input['password'] =Hash::make(request('password'));
        $employee = Employee::create($input);
        return redirect()->route('admin.employees.index')->with(['success'=>'New Employee Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::findOrFail(decrypt($id));
        $req_type = 1;
        $reviews = $employee->reviews;
        return view('admin.employees.view',compact('employee','req_type','reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail(decrypt($id));
        $branches = Branch::where('status',Utility::ITEM_ACTIVE)->orderBy('id','desc')->get();
        $states = DB::table('states')->orderBy('name','asc')->select('id','name')->get();
        return view('admin.employees.add',compact('employee','branches','states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $id = decrypt(request('employee_id'));
        $employee = Employee::find($id);
        //return Employee::DIR_PUBLIC . $employee->image;
        $validated = request()->validate([
            'name' => 'required',
            'email' => 'nullable|email|required_without:phone|unique:employees,email,'. $id,
            'phone' => 'nullable|regex:/^[0-9]{10}$/|required_without:email|unique:employees,phone,'. $id,
            'password' => 'nullable|min:6',
            'postal_code' => 'required',
            'district_id' => 'required',
            'state_id' => 'required',
        ]);
        $input = request()->except(['_token','_method','email_verified_at','image','password']);

        if(request('isImageDelete')==1) {
            Storage::delete(Employee::DIR_PUBLIC . $employee->avatar);
            $input['avatar'] =null;
        }
        if(request()->hasFile('avatar')) {
            $extension = request('avatar')->extension();
            $fileName = 'user_pic_' . date('YmdHis') . '.' . $extension;
            request('avatar')->storeAs('users', $fileName);
            $input['avatar'] =$fileName;
        }

        if(!empty(request('password'))) {
            $input['password']=Hash::make(request('password'));
        }
        //$input['user_id'] =Auth::id();
        $employee->update($input);
        return redirect()->route('admin.employees.index')->with(['success'=>'Employee Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find(decrypt($id));
        if(!empty($employee->image)) {
            Storage::delete(Employee::DIR_PUBLIC . $employee->image);
            $input['image'] =null;
        }
        $employee->delete();
        return redirect()->route('admin.employees.index')->with(['success'=>'Employee Deleted Successfully']);
    }

    public function changeStatus($id) {
        $employee = Employee::find(decrypt($id));
        $currentStatus = $employee->status;
        $status = $currentStatus ? 0 : 1;
        $employee->update(['status'=>$status]);
        return redirect()->route('admin.employees.index')->with(['success'=>'Status changed Successfully']);
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
}
