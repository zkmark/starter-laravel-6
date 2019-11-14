<?php

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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::group(['middleware'=>'language'],function (){
	
	Route::get('/', function () {
    return view('welcome');
	});

	Auth::routes();

	
});


Route::get('/home', 'HomeController@index')->name('home');



Route::get('settings', 'User\UserSettingsController@index')->name('settings');


Route::get('settings/{id}/edit', 'User\UserSettingsController@edit')->name('settings.edit');

Route::put('settings/{id}', 'User\UserSettingsController@update')->name('settings.update');

//Route::resource('/settings', 'User\UserSettingsController');

Route::get('setlocale/{locale}',function($lang){
	//\Session::put('locale',$lang);
	session(['locale'=> $lang]);
	//dd(\Config::get('app.locale'));
	return redirect()->back();   
});
