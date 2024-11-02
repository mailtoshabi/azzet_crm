<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Uom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UomController extends Controller
{
    public function index() {
        $uoms = Uom::orderBy('id','asc')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.uoms.index',compact('uoms'));
    }

    public function create() {
        return view('admin.uoms.add');
    }

    public function store () {
        $validated = request()->validate([
            'name' => 'required|unique:uoms,name',
        ]);
        $input = request()->only(['name']);
        $input['user_id'] =Auth::id();
        $uom = Uom::create($input);
        return redirect()->route('admin.uoms.index')->with(['success'=>'New Uom Added Successfully']);
    }

    public function edit($id) {
        $uom = Uom::findOrFail(decrypt($id));
        return view('admin.uoms.add',compact('uom'));
    }

    public function update () {
        $id = decrypt(request('uom_id'));
        $uom = Uom::find($id);
        //return Uom::DIR_PUBLIC . $uom->image;
        $validated = request()->validate([
            'name' => 'required|unique:uoms,name,'. $id,
        ]);
        $input = request()->only(['name']);
        $input['user_id'] =Auth::id();
        $uom->update($input);
        return redirect()->route('admin.uoms.index')->with(['success'=>'Uom Updated Successfully']);
    }

    public function destroy($id) {
        $uom = Uom::find(decrypt($id));
        $uom->delete();
        return redirect()->route('admin.uoms.index')->with(['success'=>'Uom Deleted Successfully']);
    }

    public function changeStatus($id) {
        $uom = Uom::find(decrypt($id));
        $currentStatus = $uom->status;
        $status = $currentStatus ? 0 : 1;
        $uom->update(['status'=>$status]);
        return redirect()->route('admin.uoms.index')->with(['success'=>'Status changed Successfully']);
    }
}
