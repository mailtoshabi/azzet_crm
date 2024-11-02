<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Category;
use App\Models\Component;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index() {
        $auth_id = Auth::guard('employee')->id();
        $status = request('status');
        $count_pending = Product::where('is_approved',Utility::ITEM_INACTIVE)->count();
        $is_approved = isset($status)? decrypt(request('status')) : ($count_pending==0 ? 1: 0);
        $count_new = $count_pending<99? $count_pending:'99+';
        $products = Product::orderBy('id','desc')->where('is_approved',$is_approved)->where('employee_id',$auth_id)->paginate(Utility::PAGINATE_COUNT);
        return view('admin.employee.products.index',compact('products','is_approved','count_new'));
    }

    public function create() {
        $categories = Category::where('status',Utility::ITEM_ACTIVE)->orderBy('id','desc')->get();
        return view('admin.employee.products.add',compact('categories'));
    }

    public function store () {
        $validated = request()->validate([
            'name' => 'required|unique:products,name',
            'category_id' => 'required',
        ]);
        $input = request()->only(['name','category_id','description']);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = Utility::cleanString(request()->name) . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('products', $fileName);
            $input['image'] =$fileName;
        }
        $profit = 0;
        $status = 0;
        $input['profit'] =$profit;
        $input['status'] =$status;
        $input['employee_id'] = Auth::guard('employee')->id();
        $branch_id = Auth::guard('employee')->user()->branch_id;
        $input['branch_id'] = $branch_id;
        $product = Product::create($input);

        if(!empty(request('component_names'))) {
            foreach(request('component_names') as $index => $component_id) {
                if(!empty($component_id)) {
                    $product->components()->attach($component_id, ['cost' => request('costs')[$index], 'o_cost' => request('o_costs')[$index]]);
                }
            }
        }


        return redirect()->route('employee.products.index')->with(['success'=>'New Product Added Successfully']);
    }

    public function edit($id) {
        $product = Product::findOrFail(decrypt($id));
        if(!$product->is_approved) {
        $categories = Category::where('status',Utility::ITEM_ACTIVE)->get();
        return view('admin.employee.products.add',compact('categories','product'));
        }else {
            abort(404);
        }
    }

    public function update () {
        $id = decrypt(request('product_id'));
        $product = Product::find($id);
        //return Product::DIR_PUBLIC . $product->image;
        if(!$product->is_approved) {
        $validated = request()->validate([
            'name' => 'required|unique:products,name,'. $id,
        ]);
        $input = request()->only(['name','category_id','description']);
        if(request('isImageDelete')==1) {
            Storage::delete(Product::DIR_PUBLIC . $product->image);
            $input['image'] =null;
        }
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = Utility::cleanString(request()->name) . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('products', $fileName);
            $input['image'] =$fileName;
        }
        $product->update($input);
        $product->components()->detach();
        if(!empty(request('component_names'))) {
            foreach(request('component_names') as $index => $component_id) {
                if(!empty($component_id)) {
                    $product->components()->attach($component_id, ['cost' => request('costs')[$index], 'o_cost' => request('o_costs')[$index]]);
                }
            }
        }

        return redirect()->route('employee.products.index')->with(['success'=>'Product Updated Successfully']);
    }else {
        abort(404);
    }
    }

    public function destroy($id) {
        $product = Product::find(decrypt($id));
        if(!$product->is_approved) {
        if(!empty($product->image)) {
            Storage::delete(Product::DIR_PUBLIC . $product->image);
            $input['image'] =null;
        }
        $product->delete();
        return redirect()->route('employee.products.index')->with(['success'=>'Product Deleted Successfully']);
    }else{
        abort(404);
    }
    }
}
