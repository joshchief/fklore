<?php

class AdminSpeciesController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex()
	{
		$species = Species::all();

		$data['species'] = $species;

		return View::make($this->layout.'.admin.species.index', $data);
	}

	public function getNew()
	{
	    $bloodlines = Bloodlines::all();

		$data = array(
				'bloodlines' => $bloodlines
			);
			
		return View::make($this->layout.'.admin.species.add', $data);
	}

	public function postNew()
	{
		$species = new Species;
		$species->name = Input::get('name');
		$species->bloodline_id = Input::get('bloodline_id');
		$species->horns = (Input::get('horns')) ? 1 : 0;
		$species->horns_pointed = (Input::get('horns_pointed')) ? 1 : 0;
		$species->promo = (Input::get('promo')) ? 1 : 0;
		$species->save();

		Session::flash('success', 'Species successfully created!');

		return Redirect::to('admin/species');
	}

	public function getEdit($id)
	{
		$species = Species::where('id', '=', $id)->first();
		$bloodlines = Bloodlines::all();

		$data = array(
				'species' => $species,
				'bloodlines' => $bloodlines
			);
		
		return View::make($this->layout.'.admin.species.edit', $data);
	}

	public function postEdit($id)
	{
		$species = Species::where('id', '=', $id)->first();
		$species->bloodline_id = Input::get('bloodline_id');
		$species->name = Input::get('name');
		$species->horns = (Input::get('horns')) ? 1 : 0;
		$species->horns_pointed = (Input::get('horns_pointed')) ? 1 : 0;
		$species->promo = (Input::get('promo')) ? 1 : 0;
		$species->save();
		
		Session::flash('success', 'Species updated successfully!');

		return Redirect::to('admin/species');
	}

	public function getDelete($id)
	{
		Species::where('id', '=', $id)->delete();
		
		$max = DB::table('species')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_species AUTO_INCREMENT =  $max");

		Session::flash('success', 'Species successfully deleted!');

		return Redirect::to('admin/species');
	}
	
	public function getUpload()
	{
		$species = Species::all();
        $colors = Colors::all();
        
		$data['species'] = $species;
		$data['colors'] = $colors;

		return View::make($this->layout.'.admin.species.upload', $data);
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
			return Redirect::to('/admin/species/upload')
					->with('errors', $msgArray)
					->withInput();
		}
		else
		{
		    $color = Colors::where('id', '=', Input::get('color'))->first();
		    $type = (Input::get('type') == 'horns_pointed') ? 'horns' : Input::get('type');
		    $species = Input::get('species');
		    
			// Upload item image
			$image = (Input::get('type') == 'horns_pointed') ? $color->name.'_pointed.png' : $color->name.'.png';
			
			Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/base/'.$species.'/'.$type, $image);

			// Set success message and redirect to item view all page
			Session::put('success', 'File successfully uploaded!');
			return Redirect::to('/admin/species/upload');
		}
	}
}