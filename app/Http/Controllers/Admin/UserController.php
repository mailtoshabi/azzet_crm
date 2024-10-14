<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Utilities\Utility;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index() {
        $users = User::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.users.index',compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.add',compact('roles'));
    }

    public function store()
    {
        $validated = request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required',
        ]);
        $input = request()->except(['_token','email_verified_at','password']);
        $input['password']=Hash::make(request('password'));
        if(request()->hasFile('avatar')) {
            $extension = request('avatar')->extension();
            $fileName = 'user_pic_' . date('YmdHis') . '.' . $extension;
            request('avatar')->storeAs('users', $fileName);
            $input['avatar'] =$fileName;
        }
        //$input['user_id'] =Auth::id();
        $user = User::create($input);
        $role_id = decrypt(request('role_id'));
        $user->roles()->attach($role_id);
        return redirect()->route('admin.users.index')->with(['success'=>'New User Added Successfully']);
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::findOrFail(decrypt($id));
        return view('admin.users.add',compact('user','roles'));
    }

    public function update()
    {
        $id = decrypt(request('user_id'));
        $user = User::find($id);
        $validated = request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,'. $id,
            'password' => 'nullable|min:6',
            'role_id' => 'required',
        ]);

        $input = request()->except(['_token','_method','email_verified_at','password']);

        if(!empty(request('password'))) {
            $input['password']=Hash::make(request('password'));
        }

        if(request('isImageDelete')==1) {
            Storage::delete(User::DIR_PUBLIC . $user->avatar);
            $input['avatar'] =null;
        }
        if(request()->hasFile('avatar')) {
            $extension = request('avatar')->extension();
            $fileName = 'user_pic_' . date('YmdHis') . '.' . $extension;
            request('avatar')->storeAs('users', $fileName);
            $input['avatar'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $user->update($input);
        $role_id = decrypt(request('role_id'));
        $user->roles()->sync($role_id);
        return redirect()->route('admin.users.index')->with(['success'=>'User Updated Successfully']);
    }

    public function destroy($id)
    {
        if(decrypt($id)!=Utility::ADMIN_ID || decrypt($id)!=Auth::id()) {
            $user = User::find(decrypt($id));
        if(!empty($user->avatar)) {
            Storage::delete(User::DIR_PUBLIC . $user->avatar);
            $input['avatar'] =null;
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with(['success'=>'User Deleted Successfully']);
        }

    }

    public function changeStatus($id) {
        $user = User::find(decrypt($id));
        $currentStatus = $user->status;
        $status = $currentStatus ? 0 : 1;
        $user->update(['status'=>$status]);
        return redirect()->route('admin.users.index')->with(['success'=>'Status changed Successfully']);
    }

    public function addRole() {
        $permissions = Permission::all();
        return view('admin.users.add-role');
    }
}
