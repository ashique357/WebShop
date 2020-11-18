<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\View\Composer\AdminDashboard;
use Illuminate\Support\Facades\View;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('Backend.*','App\Http\View\Composer\AdminDashboard');
    }
}
