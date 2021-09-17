<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FormatTimeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    
    //aqui tengo que carga mi helper
    public function register()
    {
         require_once app_path() . '/Helpers/FormatTime.php';
    }
}
