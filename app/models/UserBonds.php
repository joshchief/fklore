<?php

class UserBonds extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_bonds';
	
	public function npc() {
       return $this->belongsTo('Npcs', 'npc_id'); 
    }
}