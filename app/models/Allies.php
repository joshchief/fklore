<?php

class Allies extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_allies';
	
    public function user() {
        return $this->hasOne('User', 'id', 'ally_id'); 
    }
}
