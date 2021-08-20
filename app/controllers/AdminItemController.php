<?php

class AdminItemController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex()
	{
		$items = Items::all();

		$data['items'] = $items;

		return View::make($this->layout.'.admin.items.index', $data);
	}
	
	public function getEdit($id)
	{
		$item = Items::where('id', '=', $id)->first();
		$categories = ItemCategories::all();

		$data = array(
				'item' => $item,
				'categories' => $categories
			);
		
		return View::make($this->layout.'.admin.items.edit', $data);
	}

	public function postEdit($id)
	{
	    $name = Input::get('name');
		$description = Input::get('description');
		$category = Input::get('category_id');
        $itemUse = Input::get('item_use');
		$sellPrice = Input::get('sell_price');
		
		$item = Items::where('id', '=', $id)->first();
		
	    // Check if an image is being uploaded
		if (Input::hasFile('image'))
		{
				// Move uploaded file
				Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/items', $item->image);
		}
			
		$item->name = $name;
		$item->description = $description;
		$item->category_id = $category;
		$item->item_use = $itemUse;
		$item->sell_price = $sellPrice;
		$item->save();

		Session::flash('success', 'Item updated successfully!');

		return Redirect::to('admin/items');
	}
	
	public function getDelete($id)
	{
		Items::where('id', '=', $id)->delete();
		
		$max = DB::table('items')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_items AUTO_INCREMENT =  $max");

		Session::flash('success', 'Item deleted successfully!');

		return Redirect::to('admin/items');
	}
	

	public function getNew()
	{
	    $categories = ItemCategories::all();

		$data['categories'] = $categories;
		
		return View::make($this->layout.'.admin.items.add', $data);
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
			return Redirect::to('/admin/items/new')
					->with('errors', $msgArray)
					->withInput();
		}
		else
		{
		    $name = Input::get('name');
		    $description = Input::get('description');
            $category = Input::get('category_id');
            $itemUse = Input::get('item_use');
            $sellPrice = Input::get('sell_price');
            
			// Upload item image
			$image = Input::file('image')->getClientOriginalName();
			Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/items', $image);
			
			$item = new Items;
			$item->name = $name;
			$item->description = $description;
			$item->image = $image;
			$item->category_id = $category;
			$item->item_use = $itemUse;
			$item->sell_price = $sellPrice;
			$item->save();

			// Set success message and redirect
			Session::put('success', 'Item added successfully!');
			return Redirect::to('/admin/items');
		}
	}
	
	public function getCategories()
	{
		$categories = ItemCategories::all();

		$data['categories'] = $categories;

		return View::make($this->layout.'.admin.items.categories', $data);
	}

	public function getCategoryNew()
	{
		return View::make($this->layout.'.admin.items.categories_add');
	}

	public function postCategoryNew()
	{
		$category = new ItemCategories;
		$category->name = Input::get('name');
		$category->save();

		Session::flash('success', 'Category successfully created!');

		return Redirect::to('admin/items/categories');
	}

	public function getCategoryEdit($id)
	{
		$category = ItemCategories::where('id', '=', $id)->first();

		$data = array(
				'category' => $category
			);
		
		return View::make($this->layout.'.admin.items.categories_edit', $data);
	}

	public function postCategoryEdit($id)
	{
		$category = ItemCategories::where('id', '=', $id)->first();
		$category->name = Input::get('name');
		$category->save();
		
		Session::flash('success', 'Category updated successfully!');

		return Redirect::to('admin/items/categories');
	}

	public function getCategoryDelete($id)
	{
		ItemCategories::where('id', '=', $id)->delete();
		
		$max = DB::table('item_categories')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_item_categories AUTO_INCREMENT =  $max");

		Session::flash('success', 'Category successfully deleted!');

		return Redirect::to('admin/items/categories');
	}
}