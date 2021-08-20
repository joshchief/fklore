<?php

class ShopsController extends BaseController {
	
	public function __construct()
	{
		$this->beforeFilter('csrf', array('on' => 'post'));
	}
	
    public function getIndex($id)
	{
		$shop = Shops::find($id);
		
		$data['shop'] = $shop;
		
		// Get Greeting
		if(Auth::user()->bonds()->where('npc_id', '=', $shop->npc_id)->count() && Auth::user()->bonds()->where('npc_id', '=', $shop->npc_id)->first()->bond_lvl == 4)
		{
		    $greetings = $shop->greetings()->where('friendship', '=', 1)->first();
		}
		else
		{
		    $greetings = $shop->greetings()->orderByRaw("RAND()")->first();
		}
		
		$data['greeting'] = $greetings->greeting;

		return View::make($this->layout.'.shops.index', $data);
	}
	
	// DISPLAY PREMIUM SHOP -----------------------------------------------------------
	public function getPremium()
	{
		if(!Auth::check())
		{
			return Redirect::to('/user/login');
		}

		return View::make($this->layout.'.shops.premium');
	}
	
	public function getBuy($id, $item)
	{
		$shop = Shops::find($id);
		$data['shop'] = $shop;
		
		$stockCount = $shop->stock()->where('item_id', '=', $item)->count();
		
		// See if user has enough inventory space
		if(!Auth::user()->invSpace())
		{
		    return View::make($this->layout.'.shops.inventoryfull', $data);
		}
		
		if($stockCount)
		{
		    $list = $shop->items()->where('item_id', '=', $item)->first();
		    
		    // See if user has enough silver
		    if(!Auth::user()->takeCurrency('silver', $list->price))
		    {
		        $item = Items::find($item);
		    
		        $data['item'] = $item;
		    
		        return View::make($this->layout.'.shops.lowsilver', $data);
		    }
		    
		    // Decrease item stock
		    $stock = $shop->stock()->where('item_id', '=', $item)->first();

		    if($stock->qty == 1)
		    {
		        $stock->delete();
		    }
		    else
		    {
		        $stock->decrement('qty');
		        $stock->save();
		    }
		    
		    // Add item to user's inventory
		    Auth::user()->giveItem($item);
		    
		    $item = Items::find($item);
		    
		    $data['item'] = $item;
		        
		    return View::make($this->layout.'.shops.success', $data);
		}
		else
		{
		    $item = Items::find($item);
		    
		    $data['item'] = $item;
		    
		    return View::make($this->layout.'.shops.soldout', $data);
		}
	}
	
	public function getSell($id)
	{
		$shop = Shops::find($id);
		
		$data['shop'] = $shop;
        

		return View::make($this->layout.'.shops.sell', $data);
	}
	
	public function postSell($id)
	{
		$shop = Shops::find($id);
		$data['shop'] = $shop;

		$item = (int) Input::get('item');
		$qty = (int) Input::get('qty');
		
		$itemD = Items::find($item);
		    
		$data['item'] = $itemD;
		
		// See if user has item and qty
		if(Auth::user()->hasItem($item, $qty))
		{
		    if($qty >= 1)
		    {
		        // Take items
		        Auth::user()->takeItem($item, $qty);
		        
		        // Give currency
		        Auth::user()->giveCurrency('silver', $itemD->sell_price * $qty);
		    }
		    
		    $data['qty'] = $qty;
		        
		    return View::make($this->layout.'.shops.sell_success', $data);
		}
		else
		{
		   return View::make($this->layout.'.shops.sell_fail', $data);
		}
	}
}