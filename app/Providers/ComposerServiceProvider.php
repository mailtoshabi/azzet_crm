<?php

namespace App\Providers;

use App\Http\Utilities\Utility;
use App\Models\Affiliate;
use App\Models\AllSlug;
use App\Models\Category;
use App\Models\ClinicType;
use App\Models\Executive;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
// use Auth;
use Illuminate\Support\Facades\Auth;
// use Utility;

class ComposerServiceProvider extends ServiceProvider
{

    /*public function __construct($app, Request $request)
    {
        parent::__construct($app);

        $this->request = $request;
    }*/

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        view()->composer(['admin.layouts.sidebar'], function ($view) {
            $user = User::find(Auth::id());
            $view->with(compact('user'));
        });

        view()->composer(['admin.layouts.executive.sidebar'], function ($view) {
            $user = Executive::find(Auth::guard('executive')->id());
            $view->with(compact('user'));
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
