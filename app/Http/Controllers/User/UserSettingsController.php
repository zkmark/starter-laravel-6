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
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadTrait;
use Intervention\Image\Facades\Image;

class UserSettingsController extends Controller
{
	
	use UploadTrait;
	//
	public function index()
	{

		$the_user = auth()->user();
		
		$user = [
			'id' 				=> $the_user->id,
			'name' 			=> $the_user->name,
			'username' 	=> $the_user->username,
			'email'		 	=> $the_user->email,
			'new_password'	=> '',
			'avatar'		=> json_decode($the_user->avatar, true)
		];

		return view('user/settings/settings-profile', compact('user'));

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
		

		$user_id = auth()->user()->id;
		
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


	public function changeLang(Request $request, $id){

		//dd($request);
		if( $request->lang){

			$validator = Validator::make($request->all(), [
				'lang' => ['required', 'string', 'min:2', 'max:255'],
			]);

			if($validator->fails()){
				return Redirect::to('settings')
							->with('error','Error! verify your Language')
							->withErrors($validator)
							->withInput();
			}
			else{
				//User logeed
				$user_id = auth()->user()->id;

				$user = User::findOrFail($user_id);
				$update = ['lang' => $request->lang];
				$user->update($update);

				return Redirect::to('settings')
      			->with('success','Great! updated successfully');
			}
      
		}


	}

	public function avatarUpload(Request $request, $id){

		$validator = Validator::make($request->all(), [
			'name' => ['required', 'image'],
		]);
		if($validator->fails()){
			return Redirect::to('settings')
						->with('error','Error your avatar must be a valid image')
						->withErrors($validator)
						->withInput();
		}

		//Id of user logged
		$user_id = auth()->user()->id;

		// Check if a profile image has been uploaded
		if ($request->has('avatar') && $request->file('avatar')) {

			$img = $request->file('avatar');
			$img_type =	$img->getClientOriginalExtension();

			$avatar_sizes = [
				'icon' 	=>	'48',
				'xs'		=>	'192'
			];

			$this->uploadAvatars($request->file('avatar'), $user_id, $avatar_sizes);

			foreach ($avatar_sizes as $key => $value) {
				$avatar_sizes[$key] = $value . '.'. $img_type;
			}
			
			$user = User::findOrFail($user_id);
			$update = ['avatar' => json_encode($avatar_sizes)];
			$user->update($update);
			
			// Success
			return Redirect::to('settings')
			->with('success','Great! updated successfully');
		}
		else{
			return Redirect::to('settings')
			->with('error','Avatar upload failed');
		}

	}
	

	public function avatarDelete(Request $request, $id){
		$user_id = auth()->user()->id;

		$user = User::findOrFail($user_id);
		$avatar_sizes = json_decode($user->avatar, true);

		if ($avatar_sizes) {
			//deleteAvatars
			$this->deleteAvatars($user_id, $avatar_sizes);

			//Database
			$update = ['avatar' => ''];
			$user->update($update);

			// Success
			return Redirect::to('settings')
			->with('success','Great! delete successfully');
		}
		else{
			return Redirect::to('settings')
			->with('error','No avatars');
		}
		

	}
	
	//Add lang database

}
