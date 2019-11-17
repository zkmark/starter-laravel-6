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
	
	//Guest

	Route::get('/', function () {
    return view('welcome');
	});

	//Auth
	Auth::routes();

	//User
	Route::get('/home', 'HomeController@index')->name('home');

	
	//Auth
	Route::group(['middleware'=>'auth'],function (){

		//settings
		Route::get('settings', 'User\UserSettingsController@index')->name('settings');
		Route::put('settings/{id}', 'User\UserSettingsController@update')->name('settings.update');
		Route::put('settings/avatar_upload/{id}', 'User\UserSettingsController@avatarUpload')
		->name('settings.avatarUpload');
		Route::put('settings/avatar_delete/{id}', 'User\UserSettingsController@avatarDelete')
		->name('settings.avatarDelete');

		Route::put('settings/changeLang/{id}', 'User\UserSettingsController@changeLang')
		->name('settings.changeLang');
		
		Route::get('settings/{id}/edit', 'User\UserSettingsController@edit')->name('settings.edit');
	});
	
});



Route::get('setlocale/{locale}',function($lang){
	//\Session::put('locale',$lang);
	session(['locale'=> $lang]);
	//dd(\Config::get('app.locale'));
	return redirect()->back();   
});