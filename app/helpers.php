<?php

// use Illuminate\Support\Facades\Request;

use App\Http\Utilities\Utility;
use App\Models\Branch;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

if (!function_exists('set_active')) {
    function set_active($routes)
    {
        if (is_array($routes)) {
            foreach ($routes as $route) {
                if (Route::currentRouteName() == $route) {
                    return 'mm-active';
                }
            }
        } else {
            if (Route::currentRouteName() == $routes) {
                return 'mm-active';
            }
        }
        return '';
    }
}

if (!function_exists('default_branch')) {
    function default_branch()
    {
        if(Auth::id()==Utility::SUPER_ADMIN_ID) {
            if (session()->has('default_branch')) {
                $id = session()->get('default_branch');
                $default_branch = Branch::where('id',decrypt($id))->first();
            }else {
                $default_branch = Branch::where('status',Utility::ITEM_ACTIVE)->where('id',Utility::DEFAULT_BRANCH_ID)->first();
                if(!$default_branch) { $default_branch = Branch::orderBy('id','asc')->first(); }
            }
        }else {
            $default_branch = Branch::where('id',Auth::user()->branch_id)->first();
        }
        return $default_branch;
    }
}

if (!function_exists('sales_count')) {
    function sales_count($status)
    {
        if($status!=Utility::STATUS_NOTPAID) {
        $count = Sale::orderBy('sales.id','desc')

        ->join("estimates",function($join){
            $join->on("estimates.id","=","sales.estimate_id")
            ->where('estimates.branch_id',default_branch()->id);
            })

        ->join("sale_statuses",function($join) use ($status) {
            $join->on("sale_statuses.sale_id","=","sales.id")
            ->where('sale_statuses.status',$status)
            ->where('sale_statuses.is_current',Utility::ITEM_ACTIVE);
            })->distinct()->count();
        }else{
            $count = Sale::with('payments')
            ->addSelect([
                'total_paid' => Payment::select(DB::raw('COALESCE(SUM(amount), 0)'))
                    ->whereColumn('sale_id', 'sales.id')
                    ->where('status', Utility::PAYMENT_COMPLETED)
            ])
            ->addSelect([
                'sub_total' => DB::table('product_sale')
                    ->join('products', 'product_sale.product_id', '=', 'products.id')
                    ->join('hsns', 'products.hsn_id', '=', 'hsns.id')
                    ->join('tax_slabs', 'hsns.tax_slab_id', '=', 'tax_slabs.id')
                    ->select(DB::raw('SUM(product_sale.price * product_sale.quantity) + SUM((product_sale.price * product_sale.quantity) * (tax_slabs.name_tax / 100)) + (sales.delivery_charge) - (sales.round_off) - (sales.discount)'))
                    ->whereColumn('sale_id', 'sales.id')
            ])
            ->leftJoin('estimates','sales.estimate_id','=','estimates.id')
            ->where('estimates.branch_id',default_branch()->id)
            ->havingRaw('total_paid < sub_total')->distinct()->count();
        }
        $count_new = $count<99? $count:'99+';
        $data = $count_new==0?'':'<span class="badge rounded-pill bg-soft-danger text-danger float-end">' . $count_new . '</span>';
        return $data;
    }
}

if (!function_exists('sales_exe_count')) {
    function sales_exe_count($status)
    {
        if($status!=Utility::STATUS_NOTPAID) {
            $count = Sale::orderBy('sales.id','desc')
            ->join('estimates','sales.estimate_id','=','estimates.id')
            ->join('customers','estimates.customer_id','=','customers.id')
            // ->join('employees','customers.employee_id','=','employees.id')
            // ->where('employees.id',Auth::guard('employee')->id())
            ->join("employees",function($join){
                $join->on("employees.id","=","customers.employee_id")
                ->where('employees.id',Auth::guard('employee')->id());
                })
                ->join("sale_statuses",function($join) use ($status) {
                    $join->on("sale_statuses.sale_id","=","sales.id")
                    ->where('sale_statuses.status',$status)
                    ->where('sale_statuses.is_current',Utility::ITEM_ACTIVE);
                    })
            // ->where('sales.status',$status)

            ->distinct()->count();
        }else{
            $count = Sale::with('payments')
            ->addSelect([
                'total_paid' => Payment::select(DB::raw('COALESCE(SUM(amount), 0)'))
                    ->whereColumn('sale_id', 'sales.id')
                    ->where('status', Utility::PAYMENT_COMPLETED)
            ])
            ->addSelect([
                'sub_total' => DB::table('product_sale')
                    ->join('products', 'product_sale.product_id', '=', 'products.id')
                    ->join('hsns', 'products.hsn_id', '=', 'hsns.id')
                    ->join('tax_slabs', 'hsns.tax_slab_id', '=', 'tax_slabs.id')
                    ->select(DB::raw('SUM(product_sale.price * product_sale.quantity) + SUM((product_sale.price * product_sale.quantity) * (tax_slabs.name_tax / 100)) + (sales.delivery_charge) - (sales.round_off) - (sales.discount)'))
                    ->whereColumn('sale_id', 'sales.id')
            ])
            ->havingRaw('total_paid < sub_total')
            ->join('estimates','sales.estimate_id','=','estimates.id')
            ->join('customers','estimates.customer_id','=','customers.id')
            ->join('employees','customers.employee_id','=','employees.id')
            ->where('employees.id',Auth::guard('employee')->id())
            ->distinct()->count();
        }

        $count_new = $count<99? $count:'99+';
        $data = $count_new==0?'':'<span class="badge rounded-pill bg-soft-danger text-danger float-end">' . $count_new . '</span>';
        return $data;
    }
}

