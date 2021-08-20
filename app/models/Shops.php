<?php

class Shops extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'shops';
	
	public function items() {
        return $this->hasMany('ShopItems', 'shop_id'); 
    }

    public function stock() {
        return $this->hasMany('ShopStock', 'shop_id'); 
    }
    
    public function greetings() {
        return $this->hasMany('ShopGreetings', 'shop_id'); 
    }
    
    public function npc() {
        return $this->hasOne('Npcs', 'id', 'npc_id'); 
    }
}
