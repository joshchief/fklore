<?php

class Bloodlines extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bloodlines';

	// Each bloodline has many species
	public function species() {
        return $this->hasMany('Species', 'bloodline_id'); 
    }
}