<?php

class ShopStock extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'shop_stock';
	
	public function item() {
       return $this->belongsTo('Items', 'item_id'); 
    }
    
    public function info() {
       return $this->belongsTo('ShopItems', 'item_id', 'item_id'); 
    }
}
