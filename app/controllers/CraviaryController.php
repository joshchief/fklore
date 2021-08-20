<?php

class CraviaryController extends BaseController {
    
	public function getIndex()
	{
		$craviary = Craviary::orderBy('name', 'asc')->get();

		$data['craviary'] = $craviary;

		return View::make($this->layout.'.craviary.index', $data);
	}
	
}