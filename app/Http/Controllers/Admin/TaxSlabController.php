<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\TaxSlab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxSlabController extends Controller
{
    public function index() {
        $tax_slabs = TaxSlab::orderBy('id','asc')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.tax_slabs.index',compact('tax_slabs'));
    }

    public function create() {
        return view('admin.tax_slabs.add');
    }

    public function store () {
        $validated = request()->validate([
            'name_tax' => 'required|numeric|unique:tax_slabs,name_tax',
        ]);
        $input = request()->only(['name_tax']);
        $input['user_id'] =Auth::id();
        $tax_slab = TaxSlab::create($input);
        return redirect()->route('admin.tax_slabs.index')->with(['success'=>'New TaxSlab Added Successfully']);
    }

    public function edit($id) {
        $tax_slab = TaxSlab::findOrFail(decrypt($id));
        return view('admin.tax_slabs.add',compact('tax_slab'));
    }

    public function update () {
        $id = decrypt(request('tax_slab_id'));
        $tax_slab = TaxSlab::find($id);
        //return TaxSlab::DIR_PUBLIC . $tax_slab->image;
        $validated = request()->validate([
            'name_tax' => 'required|numeric|unique:tax_slabs,name_tax,'. $id,
        ]);
        $input = request()->only(['name_tax']);
        $input['user_id'] =Auth::id();
        $tax_slab->update($input);
        return redirect()->route('admin.tax_slabs.index')->with(['success'=>'TaxSlab Updated Successfully']);
    }

    public function destroy($id) {
        $tax_slab = TaxSlab::find(decrypt($id));
        if(!empty($tax_slab->image)) {
            $input['image'] =null;
        }
        $tax_slab->delete();
        return redirect()->route('admin.tax_slabs.index')->with(['success'=>'TaxSlab Deleted Successfully']);
    }

    public function changeStatus($id) {
        $tax_slab = TaxSlab::find(decrypt($id));
        $currentStatus = $tax_slab->status;
        $status = $currentStatus ? 0 : 1;
        $tax_slab->update(['status'=>$status]);
        return redirect()->route('admin.tax_slabs.index')->with(['success'=>'Status changed Successfully']);
    }
}
