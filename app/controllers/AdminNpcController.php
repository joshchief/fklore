<?php

class AdminNpcController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex()
	{
		$npcs = Npcs::all();

		$data['npcs'] = $npcs;

		return View::make($this->layout.'.admin.npcs.index', $data);
	}

	public function getNew()
	{
		return View::make($this->layout.'.admin.npcs.add');
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
			return Redirect::to('/admin/npcs/new')
					->with('errors', $msgArray)
					->withInput();
		}
		else
		{
		    $name = Input::get('name');
		    $description = Input::get('description');
		    $bond = Input::get('bond') ? 1 : 0;
            
			// Upload item image
			$image = Input::file('image')->getClientOriginalName();
			Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/npcs/icons', $image);
			
			$npc = new Npcs;
			$npc->name = $name;
			$npc->icon = $image;
			$npc->description = $description;
			$npc->bond = $bond;
			$npc->save();

			// Set success message and redirect
			Session::put('success', 'Npc added successfully!');
			return Redirect::to('/admin/npcs');
		}
	}
	
	public function getEdit($id)
	{
		$npc = Npcs::where('id', '=', $id)->first();

		$data = array(
				'npc' => $npc
			);
		
		return View::make($this->layout.'.admin.npcs.edit', $data);
	}
	
	public function postEdit($id)
	{
	    $name = Input::get('name');
		$description = Input::get('description');
		$bond = Input::get('bond') ? 1 : 0;
		
		$npc = Npcs::where('id', '=', $id)->first();
		
	    // Check if an image is being uploaded
		if (Input::hasFile('image'))
		{
				// Move uploaded file
				Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/npcs/icons', $npc->icon);
		}
			
		$npc->name = $name;
		$npc->description = $description;
		$npc->bond = $bond;
		$npc->save();

		Session::flash('success', 'Npc updated successfully!');

		return Redirect::to('admin/npcs');
	}
	
	public function getDelete($id)
	{
	    if(Shops::where('npc_id', '=', $id)->count())
	    {
	        $shop = Shops::where('npc_id', '=', $id)->first();
	        $shop->npc_id = 0;
	        $shop->save();
	    }
	    
		Npcs::where('id', '=', $id)->delete();
		
		$max = DB::table('npcs')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_npcs AUTO_INCREMENT =  $max");

		Session::flash('success', 'Npc deleted successfully!');

		return Redirect::to('admin/npcs');
	}
	
	public function getBondIndex($id)
	{
	    $npc = $id;
	    
	    $data['npc'] = $npc;
	    
		$bonds = NpcBondText::where('npc_id', '=', $npc)->get();

		$data['bonds'] = $bonds;

		return View::make($this->layout.'.admin.npcs.bond_index', $data);
	}

	public function getBondNew($id)
	{
	    $npc = $id;
	    
	    $data['npc'] = $npc;
	    
	    return View::make($this->layout.'.admin.npcs.bond_add', $data);
	}
	
	public function postBondNew($id)
	{
	    $npc = $id;
	    
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
			return Redirect::to('/admin/npcs/bond-add/'.$npc)
					->with('errors', $msgArray)
					->withInput();
		}
		else
		{
		    $description = Input::get('description');

			// Upload item image
			$image = Input::file('image')->getClientOriginalName();
			Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/npcs/images', $image);
			
			$bond = new NpcBondText;
			$bond->npc_id = $npc;
			$bond->image = $image;
			$bond->description = $description;
			$bond->bond_type = Input::get('bond_type');
			$bond->save();

			// Set success message and redirect
			Session::put('success', 'Bond text added successfully!');
			return Redirect::to('/admin/npcs/bond-text/'.$npc);
		}
	}
	
	public function getBondEdit($id)
	{
		$bond = NpcBondText::where('id', '=', $id)->first();

		$data = array(
				'bond' => $bond
			);
		
		return View::make($this->layout.'.admin.npcs.bond_edit', $data);
	}
	
	public function postBondEdit($id)
	{
		$npc = NpcBondText::where('id', '=', $id)->first()->npc_id;
		
		$description = Input::get('description');
		
		$bond = NpcBondText::where('id', '=', $id)->first();

	    // Check if an image is being uploaded
		if (Input::hasFile('image'))
		{
				// Move uploaded file
				Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/npcs/images', $bond->images);
		}
		
	    $bond->npc_id = $npc;
		$bond->description = $description;
		$bond->bond_type = Input::get('bond_type');
		$bond->save();
	    
		Session::flash('success', 'Bond text updated successfully!');

		return Redirect::to('/admin/npcs/bond-text/'.$npc);
	}
	
	public function getBondDelete($id)
	{
		$npc = NpcBondText::where('id', '=', $id)->first()->npc_id;
	    
		NpcBondText::where('id', '=', $id)->delete();
		
		$max = DB::table('npc_bond_text')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_npc_bond_text AUTO_INCREMENT =  $max");

		Session::flash('success', 'Bond text deleted successfully!');

		return Redirect::to('admin/npcs/bond-text/'.$npc);
	}
}