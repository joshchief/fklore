<?php

class Species extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'species';

	// Each species has many clothing
	public function clothing() {
        return $this->hasMany('Clothing', 'species_id'); 
    }
    
    public function bloodline() {
       return $this->belongsTo('Bloodlines', 'bloodline_id'); 
    }
}