<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait UploadTrait{

	public function uploadOne(UploadedFile $uploadedFile){
		/*
		$name = !is_null($filename) ? $filename : Str::random(25);

		$file = $uploadedFile->storeAs($folder, $name.'.'.
		$uploadedFile->getClientOriginalExtension(), $disk);

		*/
		$disk = 'public';
		$file = $uploadedFile->storeAs('/images/', 'ok'. $uploadedFile->getClientOriginalExtension(), $disk );


		return $file;
	}
	
	public function uploadAvatars(UploadedFile $img, $user_id, $avatar_sizes){

		$img_type =	$img->getClientOriginalExtension();
		
		foreach ($avatar_sizes as $key => $value) {

			$img_name = $avatar_sizes[$key] . '.' . $img_type;

			$image = Image::make($img)->encode($img_type, 80);
			$image-> resize($avatar_sizes[$key], $avatar_sizes[$key], function( $constrain ){
				$constrain->upsize();
			});
			Storage::disk('public')->put('img/u/'.$user_id. '/avatars/'. $img_name, $image->stream() );
			
		}

	}

	public function deleteAvatars($user_id, $avatar_sizes){

		
		foreach ($avatar_sizes as $key => $value) {

			$img_name = $avatar_sizes[$key];

			Storage::disk('public')->delete('img/u/'.$user_id. '/avatars/'. $img_name );

		}
		
	}
	

}