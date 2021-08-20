<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		$config = Settings::find(1);
		
		$theme = $config->theme;

		$this->layout = 'themes/'.$theme->location;
		
		View::share('siteName', 'Caniquus');

		if(Auth::check())
		{
			$roles = Auth::user()->roles();

			View::share('roleArray', $roles);
		}
	}

}
