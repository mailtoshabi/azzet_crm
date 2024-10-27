<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Component;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Estimate;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EstimateController extends Controller
{
    public function index() {
        $status = request('status');
        $count_pending = Estimate::orderBy('estimates.id','desc')
        ->leftJoin('sales','sales.estimate_id','=','estimates.id')
        ->whereNull('sales.estimate_id')
        ->where('estimates.branch_id',default_branch()->id)
        ->select('estimates.*')->count();
        // return $count_pending;
        $has_proforma = isset($status)? decrypt(request('status')) : ($count_pending==0?1:0);
        // $estimates = Estimate::orderBy('id','desc')->paginate(Utility::PAGINATE_COUNT);
        if($has_proforma==1) {
        $estimates = Estimate::orderBy('estimates.id','desc')
        ->leftJoin('sales','sales.estimate_id','=','estimates.id')
        ->whereNotNull('sales.estimate_id')
        ->where('estimates.branch_id',default_branch()->id)
        ->select('estimates.*')->distinct()
        ->paginate(Utility::PAGINATE_COUNT);
        }else {
            $estimates = Estimate::orderBy('estimates.id','desc')
        ->leftJoin('sales','sales.estimate_id','=','estimates.id')
        ->whereNull('sales.estimate_id')
        ->where('estimates.branch_id',default_branch()->id)
        ->select('estimates.*')->distinct()
        ->paginate(Utility::PAGINATE_COUNT);
        }
        // return $estimates;
        return view('admin.estimates.index',compact('estimates','has_proforma'));
    }

    public function create() {
        $customers = Customer::where('status',Utility::ITEM_ACTIVE)->where('branch_id',default_branch()->id)->orderBy('id','desc')->get();
        $products = Product::where('status',Utility::ITEM_ACTIVE)->orderBy('id','desc')->get();
        $components = Component::where('status',Utility::ITEM_ACTIVE)->orderBy('id','asc')->get();
        return view('admin.estimates.add',compact('customers','products','components'));
    }

    public function store () {
        // return request()->all();
        $validated = request()->validate([
            'customer_id' => 'required',
        ]);
        $input = request()->only(['customer_id']);
        $input['user_id'] =Auth::id();
        $branch_id = (Auth::id()==Utility::SUPER_ADMIN_ID)? default_branch()->id : Auth::user()->branch_id;
        $input['branch_id'] = $branch_id;
        $estimate = Estimate::create($input);

        if(!empty(request('products'))) {
            foreach(request('products') as $index => $product_id) {
                if(!empty($product_id)) {
                    $data = ['estimate_id' => $estimate->id, 'product_id' => $product_id, 'quantity' => request('quantities')[$index],'profit' => request('profits')[$index],'created_at' => now(),'updated_at' => now()];
                    $estimate_product = DB::table('estimate_product')->insert($data);

                    $lastInsertedId = DB::getPdo()->lastInsertId();
                    foreach(request('component_names')[$index] as $index_comp => $component_id) {
                        if(!empty($component_id)) {
                            $data_comp = ['estimate_product_id' => $lastInsertedId, 'component_id' => $component_id, 'cost' => request('costs')[$index][$index_comp],'o_cost' => request('o_costs')[$index][$index_comp],'created_at' => now(),'updated_at' => now()];
                            $estimate_product_comp = DB::table('component_estimate_product')->insert($data_comp);
                        }
                    }
                }
            }
        }

        return redirect()->route('admin.estimates.index')->with(['success'=>'New Estimate Added Successfully']);
    }

    public function edit($id) {
        $estimate = Estimate::findOrFail(decrypt($id));
        // if(!$estimate->sale) {
        foreach($estimate->products as $estimate_product) {
            $estimate_product_comps = DB::table('component_estimate_product')->where('estimate_product_id',$estimate_product->pivot->id)->get();
            $estimate_product->components = $estimate_product_comps;
        }
        $customers = Customer::where('status',Utility::ITEM_ACTIVE)->where('branch_id',default_branch()->id)->orderBy('id','desc')->get();
        $products = Product::where('status',Utility::ITEM_ACTIVE)->orderBy('id','desc')->get();
        $components = Component::where('status',Utility::ITEM_ACTIVE)->orderBy('id','asc')->get();
        return view('admin.estimates.add',compact('customers','products','estimate','components'));
    // }else {
    //     abort(404);
    // }
    }

    public function update () {
        $id = decrypt(request('estimate_id'));
        $estimate = Estimate::find($id);
        if(!$estimate->sale) {
        $validated = request()->validate([
            'customer_id' => 'required',
        ]);
        $input = request()->only(['customer_id']);

        $input['user_id'] =Auth::id();
        $estimate->update($input);
        $estimate->products()->detach();
        if(!empty(request('products'))) {
            foreach(request('products') as $index => $product_id) {
                if(!empty($product_id)) {
                    $data = ['estimate_id' => $estimate->id, 'product_id' => $product_id, 'quantity' => request('quantities')[$index],'profit' => request('profits')[$index],'created_at' => now(),'updated_at' => now()];
                    $estimate_product = DB::table('estimate_product')->insert($data);

                    $lastInsertedId = DB::getPdo()->lastInsertId();
                    foreach(request('component_names')[$index] as $index_comp => $component_id) {
                        if(!empty($component_id)) {
                            $data_comp = ['estimate_product_id' => $lastInsertedId, 'component_id' => $component_id, 'cost' => request('costs')[$index][$index_comp],'o_cost' => request('o_costs')[$index][$index_comp],'created_at' => now(),'updated_at' => now()];
                            $estimate_product_comp = DB::table('component_estimate_product')->insert($data_comp);
                        }
                    }
                }
            }
        }

        return redirect()->route('admin.estimates.index')->with(['success'=>'Estimate Updated Successfully']);
    }else {
        abort(404);
    }
    }

    public function destroy($id) {
        $estimate = Estimate::find(decrypt($id));
        if(!$estimate->sale) {
        $estimate->delete();
        return redirect()->route('admin.estimates.index')->with(['success'=>'Estimate Deleted Successfully']);
        }else{
            abort(404);
        }
    }

    public function productPrice($estimate_id,$product_id) {
        $estimate_product = DB::table('estimate_product')->where('estimate_id',$estimate_id)->where('product_id',$product_id)->first();
        $profit = $estimate_product->profit;
        $sum_price_components = DB::table('component_estimate_product')->where('estimate_product_id',$estimate_product->id)->sum('cost');
        $price = $profit + $sum_price_components;
        return $price;
    }

    public function convertToProforma($id) {
        $estimate = Estimate::find(decrypt($id));
        if(!$estimate->sale) {
        $executive_id = $estimate->enquiry->executive?$estimate->enquiry->executive->id:null;
        $input_sale = ['invoice_no'=>'','estimate_id'=>$estimate->id,'delivery_charge'=>0,'executive_id'=>$executive_id];
        $sale = Sale::create($input_sale);

        // $sum_price_components = DB::table('component_estimate_product')->where('estimate_product_id',4)->sum('cost');
        // return $estimate->products;

        foreach($estimate->products as $estimate_product) {
            $profit = $estimate_product->pivot->profit;
            $quantity = $estimate_product->pivot->quantity;
            $sum_price_components = DB::table('component_estimate_product')->where('estimate_product_id',$estimate_product->pivot->id)->sum('cost');
            $price = $profit + $sum_price_components;
            $input_product_sale = ['sale_id'=>$sale->id,'product_id'=>$estimate_product->id,'price'=>$price,'quantity'=>$quantity,'gst_id'=>0];
            DB::table('product_sale')->insert($input_product_sale);
        }

        $sale->invoice_no = 'INV-' . date('Ymd') . '-' . str_pad($sale->id, 6, '0', STR_PAD_LEFT);
        $sale->save();

        // $status = 1;
        // $estimate->update(['has_proforma'=>$status]);
        // return redirect()->route('admin.estimates.index','status='.encrypt(1))->with(['success'=>'Proforma Created Successfully']);
        $redirect_route = route('admin.estimates.index','status='.encrypt(1).'&success=1');
        return $redirect_route;
    }else {
        return abort(404);
    }
    }

    public function getProductDetail(Request $request) {
        $product_id = $request->product_id;
        $position = $request->position;
        $product = Product::find($product_id);

        $components = Component::where('status',Utility::ITEM_ACTIVE)->orderBy('id','asc')->get();


        $data='<hr><div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <select class="form-control select2" >
                                        <option value="">Profit</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="mb-3">
                                <input id="profits-'. $position . '" name="profits['. $position . ']" type="text" class="form-control"  placeholder="Profit" value="' . $product->profit . '">
                            </div>
                        </div>
                    </div><div id="component_container_'.$position.'">';
        foreach($product->components as $index => $product_component) {

            $options = '';
            foreach ($components as $component) {
                $selected = $component->id==$product_component->id ? 'selected':'';
                $options .= '<option value="' . $component->id . '"' . $selected . '>' . $component->name . '</option>';
            }
            $new_index = $position .'_'. $index;

            $data .= '<div class="row close_container" id="component_close_container_' .  $new_index . '">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Component</label>
                                <select id="component_names-'. $new_index .'" name="component_names['. $position .']['. $index .']" class="form-control select2" onChange="getcost(this.value,' . $position . ',' . $index. ');">
                                    <option value="">Select Component</option>' . $options .
                                '</select>' .

                            '</div>
                        </div>
                        <div class="col-sm-5">
                            <div class="mb-3">
                                <label>Cost</label>
                                <input id="costs-'. $new_index .'" name="costs['. $position .']['. $index .']" type="text" class="form-control" value="' . $product_component->pivot->cost . '">
                                <input id="o_costs-'. $new_index .'" name="o_costs['. $position .']['. $index .']" type="hidden" class="form-control" value="' . $product_component->pivot->cost . '">
                            </div>
                        </div>
                        <a class="btn-close" data-target="#component_close_container_' . $new_index . '"><i class="fa fa-trash"></i></a>
                    </div>';
        }
        $data_count=isset($product) ? $product->components->count()-1 : 0;
        $data_addindex = '[{"selector":".component_names","attr":"name", "value":"component_names"},{"selector":".costs","attr":"name", "value":"costs"},{"selector":".o_costs","attr":"name", "value":"o_costs"}]';
        $data_plugins = '[{"selector":".component_names","plugin":"select2"}]';
        $data_onchanges = '[{"selector":".component_names","attr":"onChange"}]';
        $data_increment = '[{"selector":".component_names","attr":"id", "value":"component_names"},{"selector":".costs","attr":"id", "value":"costs"},{"selector":".o_costs","attr":"id", "value":"o_costs"}]';

        $data .= "</div><div class=\"p-4 pt-1\">
                    <a href=\"#\" data-toggle=\"add-more-component\" data-template=\"#template_component\"
                    data-close=\".wb-close\"
                    data-container='#component_container_".$position."'
                    data-position='" . $position. "'
                    data-count='" . $data_count . "'
                    data-addindex='" . $data_addindex . "'
                    data-plugins='". $data_plugins . "'
                    data-onchanges='" . $data_onchanges. "'
                    data-increment='" . $data_increment . "'><i
                                class=\"fa fa-plus-circle\"></i>&nbsp;&nbsp;New Component</a>
                </div>";
        return $data;
    }

}
