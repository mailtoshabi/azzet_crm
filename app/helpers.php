<?php

// use Illuminate\Support\Facades\Request;

use App\Http\Utilities\Utility;
use App\Models\Branch;
use Illuminate\Support\Facades\Route;

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
        if (session()->has('default_branch')) {
            $id = session()->get('default_branch');
            $default_branch = Branch::where('id',decrypt($id))->first();
        }else {
            $default_branch = Branch::where('status',Utility::ITEM_ACTIVE)->orderBy('id','asc')->first();
        }

        return $default_branch;
    }
}
