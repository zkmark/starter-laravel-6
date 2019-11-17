<?php

namespace App\Http\Middleware;

use Closure;

use Session;
use App;
use Config;

class LanguageSwitcher
{
    /**
     * Handle an incoming request.
		 * https://stackoverflow.com/questions/55353631/laravel-5-8-setlocale-globally
		 * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
			
			if (auth()->user()->lang) {
				Session::put('locale', auth()->user()->lang);
				App::setLocale(session('locale'));
				return $next($request);
			}
			else{
				if (!Session::has('locale')){
					Session::put('locale',Config::get('app.locale'));
				}
				App::setLocale(session('locale'));
				return $next($request);
			}
			 
		}
		
}
