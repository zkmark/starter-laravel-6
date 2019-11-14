<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//my
use App\User;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
//use App;


class UserSettingsController extends Controller
{
	//
	public function index()
	{

		$the_user = auth()->user();
		$user = [
			'id' 				=> $the_user->id,
			'name' 			=> $the_user->name,
			'username' 	=> $the_user->username,
			'email'		 	=> $the_user->email,
			'new_password'		 	=> '',
		];

		/*
		$locale = App::getLocale();

		if (App::isLocale('en')) {
			App::setLocale($locale);
		}
		*/

		if(is_null(session('locale'))){
			session(['locale'=> "es"]);
		}
		session(['locale'=> "es"]);
		app()->setLocale(session('locale'));
		

		//dd($user['name']);
		return view('user/settings/settings-profile', compact('user'));

	}

	public function change_lang($lang){
		if(in_array($lang,['en','es','fa'])){
			session(['locale'=> $lang]);
		}
		return back();
	}

	public function edit($id){

		dd($user);
	}

	public function update(Request $request, $id){

		$user_id;
		$validator = Validator::make($request->all(), [
				'password' => 'required|password',
		]);

		if ($validator->fails()) {
			return Redirect::to('settings')
							->with('error','Error! verify your password')
							->withErrors($validator)
							->withInput();
		}
		else{
			$user_id = auth()->user()->id;
			if($user_id != $id){
				return Redirect::to('settings')
							->with('error','Error! verify your data');
			}
		}
		

		//request
		if( $request->name){

			$validator = Validator::make($request->all(), [
				'name' => ['required', 'string', 'min:4', 'max:255'],
			]);

			if($validator->fails()){
				return Redirect::to('settings')
							->with('error','Error! verify your name')
							->withErrors($validator)
							->withInput();
			}
			else{
				$user = User::findOrFail($user_id);
				$update = ['name' => $request->name];
				$user->update($update);

				return Redirect::to('settings')
      			->with('success','Great! updated successfully');
			}
      
		}

		if( $request->username){

			$validator = Validator::make($request->all(), [
				'username' => ['alpha_num', 'bail', 'min:4', 'max:50', 'unique:users'],
			]);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator)->withInput()
							->with('error','Error! verify your username');
			}
			else{
				$user = User::findOrFail($user_id);
				$update = ['username' => $request->username];
				$user->update($update);

				// Success
				return Redirect::to('settings')
						->with('success','Great! updated successfully');
			}
			
		}

		if( $request->email){
						
			$validator = Validator::make($request->all(), [
				'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			]);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator)->withInput()
							->with('error','Error! verify your email');
			}
			else{
				$user = User::findOrFail($user_id);
				$update = ['email' => $request->email];
				$user->update($update);

				// Success
				return Redirect::to('settings')
						->with('success','Great! updated successfully');
			}

		}

		//New Password
		if( $request->new_password){
						
			$validator = Validator::make($request->all(), [
				'new_password' => ['required', 'string', 'min:8'],
			]);

			if($validator->fails()){
				return redirect()->back()->withErrors($validator)->withInput()
							->with('error','Error! verify your new password');
			}
			else{
				$user = User::findOrFail($user_id);
				$update = ['password' => Hash::make($request->new_password)];
				$user->update($update);

				// Success
				return Redirect::to('settings')
						->with('success','Great! updated successfully');
			}

		}//new_password


	}


	/*
		Todo:
		Upload avatar
		TRasnlation of other pages, btn or form change url for translation
	*/
	

}
