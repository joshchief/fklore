<?php

class SpeciesPromo extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'species_promo';

	public function species() {
        return $this->hasOne('Species', 'id', 'species_id'); 
    }
}