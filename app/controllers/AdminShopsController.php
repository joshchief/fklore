<?php

class AdminShopsController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex()
	{
		$shops = Shops::all();

		$data['shops'] = $shops;

		return View::make($this->layout.'.admin.shops.index', $data);
	}
	
	public function getNew()
	{
	    $npcs = Npcs::all();

		$data['npcs'] = $npcs;
		
		return View::make($this->layout.'.admin.shops.add', $data);
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
			return Redirect::to('/admin/shops/new')
					->with('errors', $msgArray)
					->withInput();
		}
		else
		{
		    $name = Input::get('name');
		    $npc = Input::get('npc_id') ? Input::get('npc_id') : 0;
		    $mon = Input::get('mon') ? 1 : 0;
		    $tue = Input::get('tue') ? 1 : 0;
		    $wed = Input::get('wed') ? 1 : 0;
		    $thu = Input::get('thu') ? 1 : 0;
		    $fri = Input::get('fri') ? 1 : 0;
		    $sat = Input::get('sat') ? 1 : 0;
		    $sun = Input::get('sun') ? 1 : 0;
            
            
			// Upload item image
			$image = Input::file('image')->getClientOriginalName();
			Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/shops', $image);
			
			$shop = new Shops;
			$shop->name = $name;
			$shop->image = $image;
			$shop->npc_id = $npc;
			$shop->mon = $mon;
			$shop->tue = $tue;
			$shop->wed = $wed;
			$shop->thu = $thu;
			$shop->fri = $fri;
			$shop->sat = $sat;
			$shop->sun = $sun;
			$shop->save();

			// Set success message and redirect
			Session::put('success', 'Shop added successfully!');
			return Redirect::to('/admin/shops');
		}
	}
	
	public function getEdit($id)
	{
		$shop = Shops::where('id', '=', $id)->first();
		$npcs = Npcs::all();

		$data = array(
				'shop' => $shop,
				'npcs' => $npcs
			);
		
		return View::make($this->layout.'.admin.shops.edit', $data);
	}
	
	public function postEdit($id)
	{
	    $name = Input::get('name');
		$npc = Input::get('npc_id') ? Input::get('npc_id') : 0;
		$mon = Input::get('mon') ? 1 : 0;
		$tue = Input::get('tue') ? 1 : 0;
		$wed = Input::get('wed') ? 1 : 0;
		$thu = Input::get('thu') ? 1 : 0;
		$fri = Input::get('fri') ? 1 : 0;
		$sat = Input::get('sat') ? 1 : 0;
		$sun = Input::get('sun') ? 1 : 0;
		
		$shop = Shops::where('id', '=', $id)->first();
		
	    // Check if an image is being uploaded
		if (Input::hasFile('image'))
		{
				// Move uploaded file
				Input::file('image')->move('/home/g9capif4d3p3/public_html/public/assets/images/shops', $shop->image);
		}
			
		$shop->name = $name;
		$shop->npc_id = $npc;
		$shop->mon = $mon;
		$shop->tue = $tue;
		$shop->wed = $wed;
		$shop->thu = $thu;
		$shop->fri = $fri;
		$shop->sat = $sat;
		$shop->sun = $sun;
		$shop->save();

		Session::flash('success', 'Shop updated successfully!');

		return Redirect::to('admin/shops');
	}
	
	public function getDelete($id)
	{
		Shops::where('id', '=', $id)->delete();
		
		$max = DB::table('shops')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_shops AUTO_INCREMENT =  $max");

		Session::flash('success', 'Shop deleted successfully!');

		return Redirect::to('admin/shops');
	}
	
	public function getItemsIndex($id)
	{
	    $data['shop'] = $id;
	    
	    $items = ShopItems::where('shop_id', '=', $id)->get();

		$data['items'] = $items;
	    
		return View::make($this->layout.'.admin.shops.item_index', $data);
	}

	public function getItemsNew($id)
	{
	    $data['shop'] = $id;
	    
	    $items = Items::orderBy('name', 'asc')->get();

		$data['items'] = $items;
		
		return View::make($this->layout.'.admin.shops.item_add', $data);
	}
	
	public function postItemsNew($id)
	{
	    $shop = $id;
	    
	    $item = new ShopItems;
	    $item->shop_id = $shop;
	    $item->item_id = Input::get('item_id');
	    $item->price = (Input::get('price')) ? Input::get('price') : 1000;
	    $item->frequency = (Input::get('frequency')) ? Input::get('frequency') : 1;
	    $item->max_qty = (Input::get('max_qty')) ? Input::get('max_qty') : 3;
	    $item->save();
	    
		Session::flash('success', 'Item added successfully!');

		return Redirect::to('admin/shops/items/'.$shop);
	}
	
	public function getItemsEdit($id)
	{
		$list = ShopItems::find($id);
		$data['list'] = $list;
		
		$items = Items::orderBy('name', 'asc')->get();

		$data['items'] = $items;
	    
		return View::make($this->layout.'.admin.shops.item_edit', $data);
	}
	
	public function postItemsEdit($id)
	{
	    $shop = ShopItems::where('id', '=', $id)->first()->shop_id;
	    
	    $item = ShopItems::where('id', '=', $id)->first();
	    $item->item_id = Input::get('item_id');
	    $item->price = (Input::get('price')) ? Input::get('price') : 1000;
	    $item->frequency = (Input::get('frequency')) ? Input::get('frequency') : 1;
	    $item->max_qty = (Input::get('max_qty')) ? Input::get('max_qty') : 3;
	    $item->save();
	    
		Session::flash('success', 'Item updated successfully!');

		return Redirect::to('admin/shops/items/'.$shop);
	}
	
	public function getItemsDelete($id)
	{
		$shop = ShopItems::where('id', '=', $id)->first()->shop_id;
	    
		ShopItems::where('id', '=', $id)->delete();
		
		$max = DB::table('shop_items')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_shop_items AUTO_INCREMENT =  $max");

		Session::flash('success', 'Item deleted successfully!');

		return Redirect::to('admin/shops/items/'.$shop);
	}
	
	public function getGreetingIndex($id)
	{
		$shop = Shops::find($id);

		$data['shop'] = $shop;

		return View::make($this->layout.'.admin.shops.greeting_index', $data);
	}

	public function getGreetingNew($id)
	{
	    $data['id'] = $id;
	    
		return View::make($this->layout.'.admin.shops.greeting_add', $data);
	}
	
	public function postGreetingNew($id)
	{
	    $shop = $id;
	    
	    $greeting = new ShopGreetings;
	    $greeting->shop_id = $id;
	    $greeting->greeting = Input::get('greeting');
	    $greeting->friendship = Input::get('friendship');
	    $greeting->save();
	    
		Session::flash('success', 'Greeting added successfully!');

		return Redirect::to('admin/shops/greetings/'.$shop);
	}
	
	public function getGreetingEdit($id)
	{
		$greeting = ShopGreetings::find($id);
		$data['greeting'] = $greeting;
	    
		return View::make($this->layout.'.admin.shops.greeting_edit', $data);
	}
	
	public function postGreetingEdit($id)
	{
		$shop = ShopGreetings::where('id', '=', $id)->first()->shop_id;
		
		if(Input::get('friendship') && ShopGreetings::where('shop_id', '=', $shop)->where('friendship', '=', 1)->count())
		{
		    $friendship = ShopGreetings::where('shop_id', '=', $shop)->where('friendship', '=', 1)->first();
		    $friendship->friendship = 0;
		    $friendship->save();
		}
	    
	    $greeting = ShopGreetings::where('id', '=', $id)->first();
	    $greeting->greeting = Input::get('greeting');
	    $greeting->friendship = Input::get('friendship');
	    $greeting->save();
	    
		Session::flash('success', 'Greeting updated successfully!');

		return Redirect::to('admin/shops/greetings/'.$shop);
	}
	
	public function getGreetingDelete($id)
	{
	    $shop = ShopGreetings::where('id', '=', $id)->first()->shop_id;
	    
		ShopGreetings::where('id', '=', $id)->delete();
		
		$max = DB::table('shop_greetings')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_shop_greetings AUTO_INCREMENT =  $max");

		Session::flash('success', 'Greeting deleted successfully!');

		return Redirect::to('admin/shops/greetings/'.$shop);
	}
}