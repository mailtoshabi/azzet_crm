<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Hsn;
use App\Models\TaxSlab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HsnController extends Controller
{
    public function index() {
        $hsns = Hsn::orderBy('id','asc')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.hsns.index',compact('hsns'));
    }

    public function create() {
        $gst_slabs = TaxSlab::orderBy('id','asc')->where('status',Utility::ITEM_ACTIVE)->get();
        return view('admin.hsns.add',compact('gst_slabs'));
    }

    public function store () {
        $validated = request()->validate([
            'name' => 'required|unique:hsns,name',
            'tax_slab_id' => 'required',
        ]);
        $input = request()->only(['name','tax_slab_id']);
        $input['user_id'] =Auth::id();
        $hsn = Hsn::create($input);
        return redirect()->route('admin.hsns.index')->with(['success'=>'New Hsn Added Successfully']);
    }

    public function edit($id) {
        $hsn = Hsn::findOrFail(decrypt($id));
        $gst_slabs = TaxSlab::orderBy('id','asc')->where('status',Utility::ITEM_ACTIVE)->get();
        return view('admin.hsns.add',compact('hsn','gst_slabs'));
    }

    public function update () {
        $id = decrypt(request('hsn_id'));
        $hsn = Hsn::find($id);
        //return Hsn::DIR_PUBLIC . $hsn->image;
        $validated = request()->validate([
            'name' => 'required|unique:hsns,name,'. $id,
            'tax_slab_id' => 'required'
        ]);
        $input = request()->only(['name','tax_slab_id']);
        $input['user_id'] =Auth::id();
        $hsn->update($input);
        return redirect()->route('admin.hsns.index')->with(['success'=>'Hsn Updated Successfully']);
    }

    public function destroy($id) {
        $hsn = Hsn::find(decrypt($id));
        if(!empty($hsn->image)) {
            $input['image'] =null;
        }
        $hsn->delete();
        return redirect()->route('admin.hsns.index')->with(['success'=>'Hsn Deleted Successfully']);
    }

    public function changeStatus($id) {
        $hsn = Hsn::find(decrypt($id));
        $currentStatus = $hsn->status;
        $status = $currentStatus ? 0 : 1;
        $hsn->update(['status'=>$status]);
        return redirect()->route('admin.hsns.index')->with(['success'=>'Status changed Successfully']);
    }
}
