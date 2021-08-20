<?php

class AdminCraviaryController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}
	
	public function getIndex()
	{
		$craviary = Craviary::all();

		$data['craviary'] = $craviary;

		return View::make($this->layout.'.admin.craviary.index', $data);
	}
	
	public function getEdit($id)
	{
		$craviary = Craviary::where('id', '=', $id)->first();

		$data = array(
				'craviary' => $craviary
			);
		
		return View::make($this->layout.'.admin.craviary.edit', $data);
	}

	public function postEdit($id)
	{
	    $name = Input::get('name');
		$description = Input::get('description');
		
		$craviary = Craviary::where('id', '=', $id)->first();
		
	    // Check if an image is being uploaded
		if (Input::hasFile('image'))
		{
				// Move uploaded file
				Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/craviary', $craviary->image);
		}
			
		$craviary->name = $name;
		$craviary->description = $description;
		$craviary->save();

		Session::flash('success', 'Entry updated successfully!');

		return Redirect::to('admin/craviary');
	}
	
	public function getDelete($id)
	{
		Craviary::where('id', '=', $id)->delete();
		
		$max = DB::table('craviary')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_craviary AUTO_INCREMENT =  $max");

		Session::flash('success', 'Entry deleted successfully!');

		return Redirect::to('admin/craviary');
	}
	

	public function getNew()
	{
		return View::make($this->layout.'.admin.craviary.new');
	}
	
	public function postNew()
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
			return Redirect::to('/admin/craviary/new')
					->with('errors', $msgArray)
					->withInput();
		}
		else
		{
		    $name = Input::get('name');
		    $description = Input::get('description');

			// Upload item image
			$image = Input::file('image')->getClientOriginalName();
			Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/craviary', $image);
			
			$craviary = new Craviary;
			$craviary->name = $name;
			$craviary->description = $description;
			$craviary->image = $image;
			$craviary->save();

			// Set success message and redirect
			Session::put('success', 'Entry added successfully!');
			return Redirect::to('/admin/craviary');
		}
	}
}