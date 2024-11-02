<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Component;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ComponentController extends Controller
{
    public function index() {
        $components = Component::orderBy('id','asc')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.components.index',compact('components'));
    }

    public function create() {
        return view('admin.components.add');
    }

    public function store () {
        $validated = request()->validate([
            'name' => 'required|unique:components,name',
        ]);
        $input = request()->only(['name','cost']);
        $input['user_id'] =Auth::id();
        $component = Component::create($input);
        return redirect()->route('admin.components.index')->with(['success'=>'New Component Added Successfully']);
    }

    public function edit($id) {
        $component = Component::findOrFail(decrypt($id));
        return view('admin.components.add',compact('component'));
    }

    public function update () {
        $id = decrypt(request('component_id'));
        $component = Component::find($id);
        //return Component::DIR_PUBLIC . $component->image;
        $validated = request()->validate([
            'name' => 'required|unique:components,name,'. $id,
        ]);
        $input = request()->only(['name','cost']);
        $input['user_id'] =Auth::id();
        $component->update($input);
        return redirect()->route('admin.components.index')->with(['success'=>'Component Updated Successfully']);
    }

    public function destroy($id) {
        $component = Component::find(decrypt($id));
        $component->delete();
        return redirect()->route('admin.components.index')->with(['success'=>'Component Deleted Successfully']);
    }

    public function changeStatus($id) {
        $component = Component::find(decrypt($id));
        $currentStatus = $component->status;
        $status = $currentStatus ? 0 : 1;
        $component->update(['status'=>$status]);
        return redirect()->route('admin.components.index')->with(['success'=>'Status changed Successfully']);
    }
}
