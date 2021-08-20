<?php

class Settings extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'config';

	public function theme()
	{
		return $this->hasOne('Theme', 'id', 'default_theme');
	}

}
