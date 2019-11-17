<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//My
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
			//view()->share('siteTitle', 'laravel.com');
			//
			View::composer('*', function ($view) {
				$view->with('g_user', auth()->user() );

				//Langs for databaase
				$langs = [ 'es','en' ];
				$view->with('langs', $langs );
				
			});

    }
}
