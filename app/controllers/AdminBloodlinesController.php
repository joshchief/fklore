<?php

class AdminBloodlinesController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}
	
	public function getIndex()
	{
		$bloodlines = Bloodlines::all();

		$data['bloodlines'] = $bloodlines;

		return View::make($this->layout.'.admin.bloodlines.index', $data);
	}
	
	public function getEdit($id)
	{
		$bloodlines = Bloodlines::where('id', '=', $id)->first();

		$data = array(
				'bloodlines' => $bloodlines
			);
		
		return View::make($this->layout.'.admin.bloodlines.edit', $data);
	}

	public function postEdit($id)
	{
	    $name = Input::get('name');
		$description = Input::get('description');
		
		$bloodlines = Bloodlines::where('id', '=', $id)->first();
		$bloodlines->name = $name;
		$bloodlines->description = $description;
		$bloodlines->save();

		Session::flash('success', 'Bloodline updated successfully!');

		return Redirect::to('admin/bloodlines');
	}
	
	public function getDelete($id)
	{
		Bloodlines::where('id', '=', $id)->delete();
		
		$max = DB::table('bloodlines')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_bloodlines AUTO_INCREMENT =  $max");

		Session::flash('success', 'Bloodline deleted successfully!');

		return Redirect::to('admin/bloodlines');
	}
	

	public function getNew()
	{
		return View::make($this->layout.'.admin.bloodlines.new');
	}
	
	public function postNew()
	{
		$name = Input::get('name');
		$description = Input::get('description');
			
		$bloodlines = new Bloodlines;
		$bloodlines->name = $name;
		$bloodlines->description = $description;
		$bloodlines->save();

		// Set success message and redirect
		Session::put('success', 'Bloodline added successfully!');
		return Redirect::to('/admin/bloodlines');
	}
}