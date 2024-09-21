<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
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

    Route::group(['prefix'=>'products', 'as'=>'products.'], function() {
        Route::get('/',[ProductController::class,'index'])->name('index');
        Route::get('/create',[ProductController::class,'create'])->name('create');
        Route::post('/store',[ProductController::class,'store'])->name('store');
        Route::get('/edit/{id}',[ProductController::class,'edit'])->name('edit');
        Route::put('/update',[ProductController::class,'update'])->name('update');
        Route::delete('/destroy/{id}',[ProductController::class,'destroy'])->name('destroy');
        Route::get('/change-status/{id}',[ProductController::class,'changeStatus'])->name('changeStatus');
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


