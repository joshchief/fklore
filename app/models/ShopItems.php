<?php

class ShopItems extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'shop_items';
	
	public function item() {
       return $this->belongsTo('Items', 'item_id'); 
    }
}
