<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\View\Composer\MainMenu;
use Illuminate\Support\Facades\View;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('Frontend.*','App\Http\View\Composer\MainMenu');
    }
}
