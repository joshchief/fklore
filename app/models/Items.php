<?php

class Items extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'items';
	
	public function category() {
        return $this->hasOne('ItemCategories', 'id', 'category_id'); 
    }
}