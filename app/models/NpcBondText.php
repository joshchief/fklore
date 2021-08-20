<?php

class NpcBondText extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'npc_bond_text';
	
	public function npc() {
       return $this->belongsTo('Npcs', 'npc_id'); 
    }
}