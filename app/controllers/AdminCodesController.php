<?php

class AdminCodesController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex()
	{
		$codes = Beta::orderBy('id', 'asc')->get();

		$data['codes'] = $codes;

		return View::make($this->layout.'.admin.codes.index', $data);
	}

	public function getNew()
	{
		return View::make($this->layout.'.admin.codes.add');
	}

	public function postNew()
	{
		$code = new Beta;
		$code->code = Input::get('name');
		$code->account = (int) Input::get('account');
		$code->save();

		Session::flash('success', 'Beta Code successfully created!');

		return Redirect::to('admin/beta-codes');
	}

	public function getEdit($id)
	{
		$code = Beta::where('id', '=', $id)->first();

		$data = array(
				'code' => $code
			);
		
		return View::make($this->layout.'.admin.codes.edit', $data);
	}

	public function postEdit($id)
	{
		$code = Beta::where('id', '=', $id)->first();
		$code->code = Input::get('name');
		$code->account = (int) Input::get('account');
		$code->save();
		
		Session::flash('success', 'Beta Code updated successfully!');

		return Redirect::to('admin/beta-codes');
	}

	public function getDelete($id)
	{
		Beta::where('id', '=', $id)->delete();
		
		$max = DB::table('beta')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_beta AUTO_INCREMENT =  $max");

		Session::flash('success', 'Beta Code successfully deleted!');

		return Redirect::to('admin/beta-codes');
	}
}