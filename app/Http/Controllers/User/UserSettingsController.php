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
		$the_avatars = [
			'icon' 	=> 	'avatar_x32',
			'xs'		=>	'avatar_x256'
		];
		$user = [
			'id' 				=> $the_user->id,
			'name' 			=> $the_user->name,
			'username' 	=> $the_user->username,
			'email'		 	=> $the_user->email,
			'new_password'	=> '',
			'avatar'		=> json_decode($the_user->avatar, true)
		];


		/*
		$avatar_sizes  = json_decode($the_user->avatar, true);
		$this->deleteAvatars(  $the_user->id, $avatar_sizes );
		*/
	

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

		/*
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
		*/

		$user_id = auth()->user()->id;



		/*
		if ($request->hasFile('avatar')) {
			$file = $request->file('avatar');
			$name_img = 'avatar'. '.'. $file->getClientOriginalExtension();

			$file->move(public_path().'/images/', $name_img);
			return $name_img;
		}
		*/
		

		
		// Check if a profile image has been uploaded
		if ($request->has('avatar')) {

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
			
			//Storage::disk('public')->delete('img/u/'.$user_id. '/avatars/'. $name_img);

			return $avatar_sizes;
		}
		


		/*
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
		*/

		/*
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
		*/

	}

	public function avatarUpload(Request $request, $id){
		$user_id = auth()->user()->id;

		// Check if a profile image has been uploaded
		if ($request->has('avatar')) {

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
			
			//Storage::disk('public')->delete('img/u/'.$user_id. '/avatars/'. $name_img);

			// Success
			return Redirect::to('settings')
			->with('success','Great! updated successfully');
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

	/*
		Todo:
		Upload avatar ny form
		Delete avatar
 		TRasnlation of other pages, btn or form change url for translation
	*/
	

}
