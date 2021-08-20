<?php

class AdminClothingController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getUpload()
	{
		$species = Species::all();

		$data['species'] = $species;

		return View::make($this->layout.'.admin.clothing.upload', $data);
	}
	
	public function postUpload()
	{
	    // Set form rules
		$rules = array(
			'image' 		=> 'required',
		);

		// Set form error messages
		$messages = array(
			   'image.required'     	=> 'You must choose a file!',
		);
			
		// Send input through validator
		$validator = Validator::make(Input::all(), $rules, $messages);

		// Array that will hold our error messages
		$msgArray = array();

				// If validation fails give error messages
		if($validator->fails())
		{
			// Get our error messages
			$messages = $validator->messages();

			// See if there are any errors with the image
			if($messages->has('image'))
			{
				// Add first issue to our $msgArray
				$msgArray['image'] = $messages->first('image');
			}

			// Set error message
			Session::put('error', 'An error has occurred, File not uploaded!');

			// Redirect back to item creation page
			return Redirect::to('/admin/clothing/upload')
					->with('errors', $msgArray)
					->withInput();
		}
		else
		{
		    $name = Input::get('name');
		    $type = Input::get('type');
		    $species = Input::get('species');
		    
			// Upload item image
			$image = Input::file('image')->getClientOriginalName();
			Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/clothing/'.$type, $image);
			
			$clothing = new Clothing;
			$clothing->species_id = ($species) ? $species : 0;
			$clothing->type = $type;
			$clothing->name = $name;
			$clothing->image = $image;
			$clothing->save();

			// Set success message and redirect to item view all page
			Session::put('success', 'File successfully uploaded!');
			return Redirect::to('/admin/clothing/upload');
		}
	}
}