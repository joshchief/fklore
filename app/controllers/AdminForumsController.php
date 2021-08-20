<?php

class AdminForumsController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex()
	{
		$categories = ForumCategories::all();

		$data['categories'] = $categories;

		return View::make($this->layout.'.admin.forums.index', $data);
	}
	
	public function getNew()
	{
		return View::make($this->layout.'.admin.forums.add');
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
			return Redirect::to('/admin/forums/new')
					->with('errors', $msgArray)
					->withInput();
		}
		else
		{
		    $name = Input::get('name');
		    $description = Input::get('description');
            
            
			// Upload item image
			$image = Input::file('image')->getClientOriginalName();
			Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/forums', $image);
			
			$category = new ForumCategories;
			$category->name = $name;
			$category->image = $image;
			$category->description= $description;
			$category->staff= Input::get('staff');
			$category->save();

			// Set success message and redirect
			Session::flash('success', 'Category added successfully!');
			return Redirect::to('/admin/forums');
		}
	}
	
	public function getEdit($id)
	{
		$category = ForumCategories::where('id', '=', $id)->first();

		$data = array(
				'category' => $category,
			);
		
		return View::make($this->layout.'.admin.forums.edit', $data);
	}
	
	public function postEdit($id)
	{
	    $name = Input::get('name');
		$description = Input::get('description');
		
		$category = ForumCategories::where('id', '=', $id)->first();
		
	    // Check if an image is being uploaded
		if (Input::hasFile('image'))
		{
				// Move uploaded file
				Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/forums', $category->image);
		}
			
		$category->name = $name;
		$category->description= $description;
		$category->staff = Input::get('staff');
		$category->save();

		Session::flash('success', 'Category updated successfully!');

		return Redirect::to('admin/forums');
	}
	
	public function getDelete($id)
	{
		ForumCategories::where('id', '=', $id)->delete();
		
		$max = DB::table('forum_categories')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_forum_categories AUTO_INCREMENT =  $max");

		Session::flash('success', 'Category deleted successfully!');

		return Redirect::to('admin/forums');
	}
}