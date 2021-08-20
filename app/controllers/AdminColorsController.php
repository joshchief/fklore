<?php

class AdminColorsController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex()
	{
		$colors = Colors::all();

		$data['colors'] = $colors;

		return View::make($this->layout.'.admin.colors.index', $data);
	}

	public function getNew()
	{
		return View::make($this->layout.'.admin.colors.add');
	}

	public function postNew()
	{
		$colors = new Colors;
		$colors->name = Input::get('name');
		$colors->save();
		
		if(Input::get('skin'))
		{
		    $skin = new ColorsAvailable;
		    $skin->type = 'skin';
		    $skin->color_id = $colors->id;
		    $skin->save();
		}
		
		if(Input::get('horns'))
		{
		    $horns = new ColorsAvailable;
		    $horns->type = 'horns';
		    $horns->color_id = $colors->id;
		    $horns->save();
		}
		
		if(Input::get('eyes'))
		{
		    $eyes = new ColorsAvailable;
		    $eyes->type = 'eyes';
		    $eyes->color_id = $colors->id;
		    $eyes->save();
		}

		Session::flash('success', 'Color successfully created!');

		return Redirect::to('admin/colors');
	}

	public function getEdit($id)
	{
		$colors = Colors::where('id', '=', $id)->first();
		$skin = ColorsAvailable::where('type', '=', 'skin')->where('color_id', '=', $id)->count();
		$horns = ColorsAvailable::where('type', '=', 'horns')->where('color_id', '=', $id)->count();
		$eyes = ColorsAvailable::where('type', '=', 'eyes')->where('color_id', '=', $id)->count();

		$data = array(
				'colors' => $colors,
				'skin' => $skin,
				'horns' => $horns,
				'eyes' => $eyes
			);
		
		return View::make($this->layout.'.admin.colors.edit', $data);
	}

	public function postEdit($id)
	{
		$colors = Colors::where('id', '=', $id)->first();
		$colors->name = Input::get('name');
		$colors->save();
		
		if(Input::get('skin'))
		{
		    $skin = new ColorsAvailable;
		    $skin->type = 'skin';
		    $skin->color_id = $id;
		    $skin->save();
		}
		else
		{
		    ColorsAvailable::where('type', '=', 'skin')->where('color_id', '=', $id)->delete();
		}
		
		if(Input::get('horns'))
		{
		    $horns = new ColorsAvailable;
		    $horns->type = 'horns';
		    $horns->color_id = $id;
		    $horns->save();
		}
		else
		{
		    ColorsAvailable::where('type', '=', 'horns')->where('color_id', '=', $id)->delete();
		}
		
		if(Input::get('eyes'))
		{
		    $eyes = new ColorsAvailable;
		    $eyes->type = 'eyes';
		    $eyes->color_id = $id;
		    $eyes->save();
		}
		else
		{
		    ColorsAvailable::where('type', '=', 'eyes')->where('color_id', '=', $id)->delete();
		}
		
		Session::flash('success', 'Color updated successfully!');

		return Redirect::to('admin/colors');
	}

	public function getDelete($id)
	{
		Colors::where('id', '=', $id)->delete();
		ColorsAvailable::where('color_id', '=', $id)->delete();
		
		$max = DB::table('colors')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_colors AUTO_INCREMENT =  $max");
        
        $max = DB::table('colors_available')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_colors_available AUTO_INCREMENT =  $max");

		Session::flash('success', 'Color successfully deleted!');

		return Redirect::to('admin/colors');
	}
}