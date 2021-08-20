<?php

class AdminController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
	}

	public function getIndex()
	{
		return View::make($this->layout.'.admin.index');
	}
}