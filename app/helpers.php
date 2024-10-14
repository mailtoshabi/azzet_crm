<?php

// use Illuminate\Support\Facades\Request;
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
