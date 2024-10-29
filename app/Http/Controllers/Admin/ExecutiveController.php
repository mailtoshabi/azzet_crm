<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Branch;
use App\Models\Delivery;
use App\Models\Executive;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ExecutiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $executives = Executive::orderBy('id','desc')->where('branch_id',default_branch()->id)->paginate(Utility::PAGINATE_COUNT);
        return view('admin.executives.index',compact('executives'));
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
        return view('admin.executives.add',compact('branches','states'));
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
            'email' => 'nullable|email|required_without:phone|unique:executives,email',
            'phone' => 'nullable|regex:/^[0-9]{10}$/|required_without:email|unique:executives,phone',
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
            request('avatar')->storeAs('executives', $fileName);
            $input['avatar'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $input['branch_id'] = default_branch()->id;
        $input['password'] =Hash::make(request('password'));
        $executive = Executive::create($input);
        return redirect()->route('admin.executives.index')->with(['success'=>'New Executive Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Executive  $executive
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $executive = Executive::findOrFail(decrypt($id));
        $req_type = 1;
        $reviews = $executive->reviews;
        return view('admin.executives.view',compact('executive','req_type','reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Executive  $executive
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $executive = Executive::findOrFail(decrypt($id));
        $branches = Branch::where('status',Utility::ITEM_ACTIVE)->orderBy('id','desc')->get();
        $states = DB::table('states')->orderBy('name','asc')->select('id','name')->get();
        return view('admin.executives.add',compact('executive','branches','states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Executive  $executive
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $id = decrypt(request('executive_id'));
        $executive = Executive::find($id);
        //return Executive::DIR_PUBLIC . $executive->image;
        $validated = request()->validate([
            'name' => 'required',
            'email' => 'nullable|email|required_without:phone|unique:executives,email,'. $id,
            'phone' => 'nullable|regex:/^[0-9]{10}$/|required_without:email|unique:executives,phone,'. $id,
            'password' => 'nullable|min:6',
            'postal_code' => 'required',
            'district_id' => 'required',
            'state_id' => 'required',
        ]);
        $input = request()->except(['_token','_method','email_verified_at','image','password']);

        if(request('isImageDelete')==1) {
            Storage::delete(Executive::DIR_PUBLIC . $executive->avatar);
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
        $executive->update($input);
        return redirect()->route('admin.executives.index')->with(['success'=>'Executive Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Executive  $executive
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $executive = Executive::find(decrypt($id));
        if(!empty($executive->image)) {
            Storage::delete(Executive::DIR_PUBLIC . $executive->image);
            $input['image'] =null;
        }
        $executive->delete();
        return redirect()->route('admin.executives.index')->with(['success'=>'Executive Deleted Successfully']);
    }

    public function changeStatus($id) {
        $executive = Executive::find(decrypt($id));
        $currentStatus = $executive->status;
        $status = $currentStatus ? 0 : 1;
        $executive->update(['status'=>$status]);
        return redirect()->route('admin.executives.index')->with(['success'=>'Status changed Successfully']);
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
