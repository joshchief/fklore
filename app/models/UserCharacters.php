<?php

class UserCharacters extends Eloquent {
    protected $softDelete = true;
    
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_characters';

    public function species() {
       return $this->belongsTo('Species', 'species_id'); 
    }
    
    public function grabElement() {
       return $this->belongsTo('Elements', 'element'); 
    }
    
    public function owner() {
       return $this->belongsTo('User', 'user_id'); 
    }
}