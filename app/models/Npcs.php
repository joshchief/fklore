<?php

class Npcs extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'npcs';
	
	public function text() {
        return $this->hasMany('NpcBondText', 'npc_id'); 
    }
    
}