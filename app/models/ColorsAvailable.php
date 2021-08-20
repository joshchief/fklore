<?php

class ColorsAvailable extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'colors_available';

	// Each available color belongs to one color
	public function color() {
       return $this->belongsTo('Colors', 'color_id'); 
    }
}