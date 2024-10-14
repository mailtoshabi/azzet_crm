<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ComponentController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\EstimateController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ActivityController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/all_cache', function() {

    Artisan::call('cache:clear');
    Artisan::call('optimize');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return '<h1>All cache cleared</h1>';
});

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/test', [HomeController::class, 'test'])->name('test');

Auth::routes(['login' => false]);
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class,'showLoginForm']);
    Route::post('/login', [AdminLoginController::class,'login'])->name('login');
});

Route::get('/admin', [AdminHomeController::class,'index'])->middleware('auth')->name('admin');
Route::group(['as'=>'admin.', 'middleware'=>'auth', 'prefix'=>'admin'], function() {
    Route::get('/dashboard', [AdminHomeController::class,'index'])->name('dashboard');

    Route::group(['prefix'=>'categories', 'as'=>'categories.'], function() {
        Route::get('/',[CategoryController::class,'index'])->name('index');
        Route::get('/create',[CategoryController::class,'create'])->name('create');
        Route::post('/store',[CategoryController::class,'store'])->name('store');
        Route::get('/edit/{id}',[CategoryController::class,'edit'])->name('edit');
        Route::put('/update',[CategoryController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[CategoryController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[CategoryController::class,'changeStatus'])->name('changeStatus');
    });

    Route::group(['prefix'=>'components', 'as'=>'components.'], function() {
        Route::get('/',[ComponentController::class,'index'])->name('index');
        Route::get('/create',[ComponentController::class,'create'])->name('create');
        Route::post('/store',[ComponentController::class,'store'])->name('store');
        Route::get('/edit/{id}',[ComponentController::class,'edit'])->name('edit');
        Route::put('/update',[ComponentController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[ComponentController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[ComponentController::class,'changeStatus'])->name('changeStatus');
    });

    Route::group(['prefix'=>'products', 'as'=>'products.'], function() {
        Route::get('/',[ProductController::class,'index'])->name('index');
        Route::get('/create',[ProductController::class,'create'])->name('create');
        Route::post('/store',[ProductController::class,'store'])->name('store');
        Route::get('/edit/{id}',[ProductController::class,'edit'])->name('edit');
        Route::put('/update',[ProductController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[ProductController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[ProductController::class,'changeStatus'])->name('changeStatus');
        Route::post('/get-cost',[ProductController::class,'getCost'])->name('get_cost');
    });

    Route::group(['prefix'=>'customers', 'as'=>'customers.'], function() {
        Route::get('/',[CustomerController::class,'index'])->name('index');
        Route::get('/create',[CustomerController::class,'create'])->name('create');
        Route::post('/store',[CustomerController::class,'store'])->name('store');
        Route::get('/edit/{id}',[CustomerController::class,'edit'])->name('edit');
        Route::get('/show/{id}',[CustomerController::class,'show'])->name('view');
        Route::put('/update',[CustomerController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[CustomerController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[CustomerController::class,'changeStatus'])->name('changeStatus');
        Route::post('/districts', [CustomerController::class,'distric_list'])->name('list.districts');
    });

    Route::group(['prefix'=>'enquiries', 'as'=>'enquiries.'], function() {
        Route::get('/',[EnquiryController::class,'index'])->name('index');
        Route::get('/create',[EnquiryController::class,'create'])->name('create');
        Route::post('/store',[EnquiryController::class,'store'])->name('store');
        Route::get('/edit/{id}',[EnquiryController::class,'edit'])->name('edit');
        Route::put('/update',[EnquiryController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[EnquiryController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[EnquiryController::class,'changeStatus'])->name('changeStatus');
        Route::get('/convert-to-estimate/{id}',[EnquiryController::class,'convertToEstimate'])->name('convert_to_estimate');
        Route::post('/get-product-detail',[EnquiryController::class,'getProductDetail'])->name('get_product_detail');
        Route::post('/store_as_estimate',[EnquiryController::class,'store_as_estimate'])->name('store_as_estimate');
    });

    Route::group(['prefix'=>'estimates', 'as'=>'estimates.'], function() {
        Route::get('/',[EstimateController::class,'index'])->name('index');
        Route::get('/create',[EstimateController::class,'create'])->name('create');
        Route::post('/store',[EstimateController::class,'store'])->name('store');
        Route::get('/edit/{id}',[EstimateController::class,'edit'])->name('edit');
        Route::put('/update',[EstimateController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[EstimateController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[EstimateController::class,'changeStatus'])->name('changeStatus');
        Route::post('/get-product-detail',[EstimateController::class,'getProductDetail'])->name('get_product_detail');
    });

    Route::group(['prefix'=>'activities', 'as'=>'activities.'], function() {
        Route::get('/',[ActivityController::class,'index'])->name('index');
    });
});

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

// Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

//Route::get('/test', [App\Http\Controllers\HomeController::class, 'test'])->name('test');


