<?php

namespace App\Http\Controllers\Admin;

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
        $products = Product::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.products.index',compact('products'));
    }

    public function create() {
        $categories = Category::where('status',Utility::ITEM_ACTIVE)->get();
        $components = Component::where('status',Utility::ITEM_ACTIVE)->get();
        return view('admin.products.add',compact('categories','components'));
    }

    public function store () {
        $validated = request()->validate([
            'name' => 'required|unique:products,name',
            'category_id' => 'required',
        ]);
        $input = request()->only(['name','category_id','profit']);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = Utility::cleanString(request()->name) . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('products', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $product = Product::create($input);

        if(!empty(request('component_names'))) {
            foreach(request('component_names') as $index => $component_id) {
                if(!empty($component_id)) {
                    $product->components()->attach($component_id, ['cost' => request('costs')[$index], 'o_cost' => request('o_costs')[$index]]);
                }
            }
        }


        return redirect()->route('admin.products.index')->with(['success'=>'New Product Added Successfully']);
    }

    public function edit($id) {
        $product = Product::findOrFail(decrypt($id));
        $categories = Category::where('status',Utility::ITEM_ACTIVE)->get();
        $components = Component::where('status',Utility::ITEM_ACTIVE)->get();
        return view('admin.products.add',compact('categories','components','product'));
    }

    public function update () {
        $id = decrypt(request('product_id'));
        $product = Product::find($id);
        //return Product::DIR_PUBLIC . $product->image;
        $validated = request()->validate([
            'name' => 'required|unique:products,name,'. $id,
        ]);
        $input = request()->only(['name','category_id','profit']);
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
        $input['user_id'] =Auth::id();
        $product->update($input);
        $product->components()->detach();
        if(!empty(request('component_names'))) {
            foreach(request('component_names') as $index => $component_id) {
                if(!empty($component_id)) {
                    $product->components()->attach($component_id, ['cost' => request('costs')[$index], 'o_cost' => request('o_costs')[$index]]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with(['success'=>'Product Updated Successfully']);
    }

    public function destroy($id) {
        $product = Product::find(decrypt($id));
        if(!empty($product->image)) {
            Storage::delete(Product::DIR_PUBLIC . $product->image);
            $input['image'] =null;
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with(['success'=>'Product Deleted Successfully']);
    }

    public function changeStatus($id) {
        $product = Product::find(decrypt($id));
        $currentStatus = $product->status;
        $status = $currentStatus ? 0 : 1;
        $product->update(['status'=>$status]);
        return redirect()->route('admin.products.index')->with(['success'=>'Status changed Successfully']);
    }

    public function getCost(Request $request) {
        $component_id = $request->component_id;
        $position = $request->position;
        $component = Component::find($component_id);
        return $component->cost;
    }
}
