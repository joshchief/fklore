<?php

class AdminPromoController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex()
	{
		$promos = SpeciesPromo::all();

		$data['promos'] = $promos;

		return View::make($this->layout.'.admin.promo.index', $data);
	}

	public function getNew()
	{
	    $species = Species::where('promo', '=', 1)->get();

		$data = array(
				'species' => $species
			);
			
		return View::make($this->layout.'.admin.promo.add', $data);
	}

	public function postNew()
	{
		$promo = new SpeciesPromo;
		$promo->code = Input::get('code');
		$promo->species_id = Input::get('species_id');
		$promo->save();

		Session::flash('success', 'Promo successfully added!');

		return Redirect::to('admin/promo-codes');
	}

	public function getEdit($id)
	{
		$promo = SpeciesPromo::where('id', '=', $id)->first();
		$species = Species::where('promo', '=', 1)->get();

		$data = array(
				'species' => $species,
				'promo' => $promo
			);
		
		return View::make($this->layout.'.admin.promo.edit', $data);
	}

	public function postEdit($id)
	{
		$promo = SpeciesPromo::where('id', '=', $id)->first();
		$promo->code = Input::get('code');
		$promo->species_id = Input::get('species_id');
		$promo->save();
		
		Session::flash('success', 'Promo updated successfully!');

		return Redirect::to('admin/promo-codes');
	}

	public function getDelete($id)
	{
		SpeciesPromo::where('id', '=', $id)->delete();
		
		$max = DB::table('species_promo')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_species_promo AUTO_INCREMENT =  $max");

		Session::flash('success', 'Promo successfully deleted!');

		return Redirect::to('admin/promo-codes');
	}
}