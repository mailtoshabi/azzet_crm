<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Executive\HomeController as ExecutiveHomeController;
use App\Http\Controllers\Executive\Auth\LoginController as ExecutiveLoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ComponentController;
use App\Http\Controllers\Admin\UomController;
use App\Http\Controllers\Admin\HsnController;
use App\Http\Controllers\Admin\TaxSlabController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Executive\EnquiryController as ExecutiveEnquiryController;
use App\Http\Controllers\Admin\EstimateController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Executive\SaleController as ExecutiveSaleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Executive\ProductController as ExecutiveProductController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Executive\CustomerController as ExecutiveCustomerController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ExecutiveController;
use App\Http\Controllers\Admin\RoleController;

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

    Route::group(['prefix'=>'categories', 'as'=>'categories.', 'middleware' => ['role:Administrator|Manager']], function() {
        Route::get('/',[CategoryController::class,'index'])->name('index');
        Route::get('/create',[CategoryController::class,'create'])->name('create');
        Route::post('/store',[CategoryController::class,'store'])->name('store');
        Route::get('/edit/{id}',[CategoryController::class,'edit'])->name('edit');
        Route::put('/update',[CategoryController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[CategoryController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[CategoryController::class,'changeStatus'])->name('changeStatus');
    });

    Route::group(['prefix'=>'components', 'as'=>'components.', 'middleware' => ['role:Administrator']], function() {
        Route::get('/',[ComponentController::class,'index'])->name('index');
        Route::get('/create',[ComponentController::class,'create'])->name('create');
        Route::post('/store',[ComponentController::class,'store'])->name('store');
        Route::get('/edit/{id}',[ComponentController::class,'edit'])->name('edit');
        Route::put('/update',[ComponentController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[ComponentController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[ComponentController::class,'changeStatus'])->name('changeStatus');
    });

    Route::group(['prefix'=>'uoms', 'as'=>'uoms.', 'middleware' => ['role:Administrator']], function() {
        Route::get('/',[UomController::class,'index'])->name('index');
        Route::get('/create',[UomController::class,'create'])->name('create');
        Route::post('/store',[UomController::class,'store'])->name('store');
        Route::get('/edit/{id}',[UomController::class,'edit'])->name('edit');
        Route::put('/update',[UomController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[UomController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[UomController::class,'changeStatus'])->name('changeStatus');
    });

    Route::group(['prefix'=>'hsns', 'as'=>'hsns.', 'middleware' => ['role:Administrator']], function() {
        Route::get('/',[HsnController::class,'index'])->name('index');
        Route::get('/create',[HsnController::class,'create'])->name('create');
        Route::post('/store',[HsnController::class,'store'])->name('store');
        Route::get('/edit/{id}',[HsnController::class,'edit'])->name('edit');
        Route::put('/update',[HsnController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[HsnController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[HsnController::class,'changeStatus'])->name('changeStatus');
    });

    Route::group(['prefix'=>'gst-slabs', 'as'=>'tax_slabs.', 'middleware' => ['role:Administrator']], function() {
        Route::get('/',[TaxSlabController::class,'index'])->name('index');
        Route::get('/create',[TaxSlabController::class,'create'])->name('create');
        Route::post('/store',[TaxSlabController::class,'store'])->name('store');
        Route::get('/edit/{id}',[TaxSlabController::class,'edit'])->name('edit');
        Route::put('/update',[TaxSlabController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[TaxSlabController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[TaxSlabController::class,'changeStatus'])->name('changeStatus');
    });

    Route::group(['prefix'=>'products', 'as'=>'products.', 'middleware' => ['role:Administrator|Manager']], function() {
        Route::get('/',[ProductController::class,'index'])->name('index');
        Route::get('/create',[ProductController::class,'create'])->name('create');
        Route::post('/store',[ProductController::class,'store'])->name('store');
        Route::get('/edit/{id}',[ProductController::class,'edit'])->name('edit');
        Route::put('/update',[ProductController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[ProductController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[ProductController::class,'changeStatus'])->name('changeStatus');
        Route::get('/approve/{id}',[ProductController::class,'approve'])->name('approve');
        Route::post('/get-cost',[ProductController::class,'getCost'])->name('get_cost');
    });

    Route::group(['prefix'=>'parties', 'as'=>'customers.', 'middleware' => ['role:Administrator|Manager']], function() {
        Route::get('/',[CustomerController::class,'index'])->name('index');
        Route::get('/create',[CustomerController::class,'create'])->name('create');
        Route::post('/store',[CustomerController::class,'store'])->name('store');
        Route::get('/edit/{id}',[CustomerController::class,'edit'])->name('edit');
        Route::get('/show/{id}',[CustomerController::class,'show'])->name('view');
        Route::put('/update',[CustomerController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[CustomerController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[CustomerController::class,'changeStatus'])->name('changeStatus');
        Route::get('/approve/{id}',[CustomerController::class,'approve'])->name('approve');
        Route::post('/districts', [CustomerController::class,'distric_list'])->name('list.districts');
        Route::post('/add-executive',[CustomerController::class,'addExecutive'])->name('addExecutive');
    });

    Route::group(['prefix'=>'enquiries', 'as'=>'enquiries.', 'middleware' => ['role:Administrator|Manager|HR']], function() {
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

    Route::group(['prefix'=>'estimates', 'as'=>'estimates.', 'middleware' => ['role:Administrator|Manager|HR']], function() {
        Route::get('/',[EstimateController::class,'index'])->name('index');
        Route::get('/create',[EstimateController::class,'create'])->name('create');
        Route::post('/store',[EstimateController::class,'store'])->name('store');
        Route::get('/edit/{id}',[EstimateController::class,'edit'])->name('edit');
        Route::put('/update',[EstimateController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[EstimateController::class,'destroy'])->name('destroy');
        Route::get('/convert_to_proforma/{id}',[EstimateController::class,'convertToProforma'])->name('convertToProforma');
        Route::post('/get-product-detail',[EstimateController::class,'getProductDetail'])->name('get_product_detail');
    });

    Route::group(['prefix'=>'proforma', 'as'=>'sales.', 'middleware' => ['role:Administrator|Manager|HR']], function() {
        Route::get('/',[SaleController::class,'index'])->name('index');
        Route::get('/show/{id}',[SaleController::class,'show'])->name('view');
        Route::get('/download-invoice/{id}',[SaleController::class,'download_invoice'])->name('download.invoice');
        Route::get('/view-invoice/{id}',[SaleController::class,'view_invoice'])->name('view.invoice');
        Route::post('/add-frieght',[SaleController::class,'addFreight'])->name('addFreight');
        Route::post('/add-discount',[SaleController::class,'addDiscount'])->name('addDiscount');
        Route::get('/change-status/{id}/{status}',[SaleController::class,'changeStatus'])->name('changeStatus');
    });

    Route::group(['prefix'=>'branches', 'as'=>'branches.', 'middleware' => ['role:Administrator']], function() {
        Route::get('/',[BranchController::class,'index'])->name('index');
        Route::get('/create',[BranchController::class,'create'])->name('create');
        Route::post('/store',[BranchController::class,'store'])->name('store');
        Route::get('/edit/{id}',[BranchController::class,'edit'])->name('edit');
        Route::get('/show/{id}',[BranchController::class,'show'])->name('view');
        Route::put('/update',[BranchController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[BranchController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[BranchController::class,'changeStatus'])->name('changeStatus');
        Route::get('/make-default/{id}',[BranchController::class,'makeDefault'])->name('makeDefault');
        Route::post('/make-global-default',[BranchController::class,'makeDefaultGlobal'])->name('makeDefaultGlobal');
        Route::post('/districts', [BranchController::class,'distric_list'])->name('list.districts');
    });

    Route::group(['prefix'=>'executives', 'as'=>'executives.', 'middleware' => ['role:Administrator']], function() {
        Route::get('/',[ExecutiveController::class,'index'])->name('index');
        Route::get('/create',[ExecutiveController::class,'create'])->name('create');
        Route::post('/store',[ExecutiveController::class,'store'])->name('store');
        Route::get('/show/{id}',[ExecutiveController::class,'show'])->name('view');
        Route::get('/edit/{id}',[ExecutiveController::class,'edit'])->name('edit');
        Route::put('/update',[ExecutiveController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[ExecutiveController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[ExecutiveController::class,'changeStatus'])->name('changeStatus');
        Route::post('/districts', [ExecutiveController::class,'distric_list'])->name('list.districts');
    });

    Route::group(['prefix'=>'users', 'as'=>'users.', 'middleware' => ['role:Administrator']], function() {
        Route::get('/',[UserController::class,'index'])->name('index');
        Route::get('/create',[UserController::class,'create'])->name('create');
        Route::post('/store',[UserController::class,'store'])->name('store');
        Route::get('/edit/{id}',[UserController::class,'edit'])->name('edit');
        Route::put('/update',[UserController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[UserController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[UserController::class,'changeStatus'])->name('changeStatus');
    });

    Route::resource('/roles',RoleController::class)->middleware('role:Administrator');

    Route::group(['prefix'=>'activities', 'as'=>'activities.'], function() {
        Route::get('/',[ActivityController::class,'index'])->name('index');
    });
});
// Admin Dashboard Routes --End--

// Executive Dashboard Routes --Start--

Route::get('/executive', [ExecutiveHomeController::class,'index'])->middleware('executive.auth')->name('executive');
Route::group(['as'=>'executive.', 'prefix'=>'executive'], function() {
    Route::group(['namespace'=>'Executive\Auth'], function () {
        Route::get('/login', [ExecutiveLoginController::class,'login'])->name('login');
        Route::post('/do-login', [ExecutiveLoginController::class,'doLogin'])->name('do.login');
        Route::post('/logout', [ExecutiveLoginController::class,'logout'])->name('logout');
    });
    Route::get('/dashboard', [ExecutiveHomeController::class,'index'])->middleware('executive.auth')->name('dashboard');

    Route::group(['middleware'=>'executive.auth'], function () {
        Route::group(['prefix'=>'enquiries', 'as'=>'enquiries.'], function() {
            Route::get('/',[ExecutiveEnquiryController::class,'index'])->name('index');
            Route::get('/create',[ExecutiveEnquiryController::class,'create'])->name('create');
            Route::post('/store',[ExecutiveEnquiryController::class,'store'])->name('store');
            Route::get('/edit/{id}',[ExecutiveEnquiryController::class,'edit'])->name('edit');
            Route::put('/update',[ExecutiveEnquiryController::class,'update'])->name('update');
            Route::delete('/destroy/{id}',[ExecutiveEnquiryController::class,'destroy'])->name('destroy');
            Route::get('/change-status/{id}',[ExecutiveEnquiryController::class,'changeStatus'])->name('changeStatus');
            // Route::get('/convert-to-estimate/{id}',[EnquiryController::class,'convertToEstimate'])->name('convert_to_estimate');
            Route::post('/get-product-detail',[ExecutiveEnquiryController::class,'getProductDetail'])->name('get_product_detail');
            // Route::post('/store_as_estimate',[EnquiryController::class,'store_as_estimate'])->name('store_as_estimate');
        });

        Route::group(['prefix'=>'products', 'as'=>'products.'], function() {
            Route::get('/',[ExecutiveProductController::class,'index'])->name('index');
            Route::get('/create',[ExecutiveProductController::class,'create'])->name('create');
            Route::post('/store',[ExecutiveProductController::class,'store'])->name('store');
            Route::get('/edit/{id}',[ExecutiveProductController::class,'edit'])->name('edit');
            Route::put('/update',[ExecutiveProductController::class,'update'])->name('update');
            Route::delete('/destroy/{id}',[ExecutiveProductController::class,'destroy'])->name('destroy');
            Route::get('/approve/{id}',[ExecutiveProductController::class,'approve'])->name('approve');

        });

        Route::group(['prefix'=>'parties', 'as'=>'customers.'], function() {
            Route::get('/',[ExecutiveCustomerController::class,'index'])->name('index');
            Route::get('/create',[ExecutiveCustomerController::class,'create'])->name('create');
            Route::post('/store',[ExecutiveCustomerController::class,'store'])->name('store');
            Route::get('/edit/{id}',[ExecutiveCustomerController::class,'edit'])->name('edit');
            Route::get('/show/{id}',[ExecutiveCustomerController::class,'show'])->name('view');
            Route::put('/update',[ExecutiveCustomerController::class,'update'])->name('update');
            Route::delete('/destroy/{id}',[ExecutiveCustomerController::class,'destroy'])->name('destroy');
            // Route::get('/change-status/{id}',[ExecutiveCustomerController::class,'changeStatus'])->name('changeStatus');
            // Route::get('/approve/{id}',[ExecutiveCustomerController::class,'approve'])->name('approve');
            Route::post('/districts', [ExecutiveCustomerController::class,'distric_list'])->name('list.districts');
        });

        Route::group(['prefix'=>'proforma', 'as'=>'sales.'], function() {
            Route::get('/',[ExecutiveSaleController::class,'index'])->name('index');
            Route::get('/show/{id}',[ExecutiveSaleController::class,'show'])->name('view');
            Route::get('/download-invoice/{id}',[ExecutiveSaleController::class,'download_invoice'])->name('download.invoice');
            Route::get('/view-invoice/{id}',[ExecutiveSaleController::class,'view_invoice'])->name('view.invoice');
            Route::post('/add-frieght',[ExecutiveSaleController::class,'addFreight'])->name('addFreight');
            Route::post('/add-discount',[ExecutiveSaleController::class,'addDiscount'])->name('addDiscount');
            Route::get('/change-status/{id}/{status}',[ExecutiveSaleController::class,'changeStatus'])->name('changeStatus');
        });
    });
});
// Executive Dashboard Routes --End--


//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

// Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index.home');

//Route::get('/test', [App\Http\Controllers\HomeController::class, 'test'])->name('test');


