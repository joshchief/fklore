<?php

class WardrobeController extends BaseController {

    
	public function getIndex()
	{
	    // Get user character
		$character = Auth::user()->activeCharacter;
		$species = Species::all();
		$skins = ColorsAvailable::where('type', '=', 'skin')->get();
		$eyes = ColorsAvailable::where('type', '=', 'eyes')->get();
		$horns = ColorsAvailable::where('type', '=', 'horns')->get();
		
		$backgrounds = Clothing::where('type', '=', 'background')->get();
		
		$backgroundArray = array();

		foreach($backgrounds AS $item)
		{
			$backgroundArray[$item->image] = $item->name;
		}

		$headClothing = Clothing::where('species_id', '=', 1)->where('type', '=', 'head')->get();

		$headArray = array();

		foreach($headClothing AS $item)
		{
			$headArray[$item->image] = $item->name;
		}

		$accessoryClothing = Clothing::where('species_id', '=', 1)->where('type', '=', 'accessory')->get();

		$accessoryArray = array();

		foreach($accessoryClothing AS $item)
		{
			$accessoryArray[$item->image] = $item->name;
		}

		$topClothing = Clothing::where('species_id', '=', 1)->where('type', '=', 'top')->get();

		$topArray = array();

		foreach($topClothing AS $item)
		{
			$topArray[$item->image] = $item->name;
		}

		$bottomClothing = Clothing::where('species_id', '=', 1)->where('type', '=', 'bottom')->get();

		$bottomArray = array();

		foreach($bottomClothing AS $item)
		{
			$bottomArray[$item->image] = $item->name;
		}

		$data = array(
		    'character' => $character,
			'species' => $species,
			'skins' => $skins,
			'eyes' => $eyes,
			'horns' => $horns,
			'headArray' => $headArray,
			'accessoryArray' => $accessoryArray,
			'topArray' => $topArray,
			'bottomArray' => $bottomArray,
			'backgroundArray' => $backgroundArray
		);

		return View::make($this->layout.'.wardrobe.index', $data);
	}

	public function postGenerate()
	{
		$species = Input::get('species');
		$skin = Input::get('skin');
		$eyes = Input::get('eyes');
		$clothes = Input::get('clothes');
		$horns = Input::get('horns');
		$background = Input::get('background');

		// Set base img path
		$basePath = '/home/g9capif4d3p3/public_html/public/assets/images/base/'.$species.'/';

		$image = Image::canvas(800, 800);
		
		if($background)
		{
		    $backgroundImg = Image::make('/home/g9capif4d3p3/public_html/public/assets/images/clothing/background/'.$background);
		}
		
		$skinImg = Image::make($basePath.'skin/'.$skin.'.png');
		
		if($horns)
		{
		    $hornsImg = Image::make($basePath.'horns/'.$horns.'.png');
		}
		
		$eyesImg = Image::make($basePath.'eyes/'.$eyes.'.png');
		//$lineart = Image::make($basePath.'lineart.png');
        
        if($background)
		{
            $image->insert($backgroundImg);
		}
		
		$image->insert($skinImg);
		
		if($horns)
		{
		    $image->insert($hornsImg);
		}
		
		$image->insert($eyesImg);
		//$image->insert($lineart);

		if(count($clothes) > 0)
	    {
	    	$clothing = Clothing::whereIn('image', $clothes)->get();
	    	$clothingArray = array();

	    	foreach($clothing AS $cloth)
	    	{
	    		$clothingPath = '/home/g9capif4d3p3/public_html/public/assets/images/clothing/'.$cloth->type.'/'.$cloth->image;

	    		$clothingArray[$cloth->image] = $clothingPath;
	    	}

	    	foreach(array_reverse($clothes) AS $cloth)
	    	{
	    		$piece = Image::make($clothingArray[$cloth]);
	    		$image->insert($piece);
	    	}
	    }

		$response['image'] = (string) $image->encode('data-url');

		// Return response to demo
		return Response::json($response);
	}

	public function postClothes()
	{
		$species = Species::where('name', '=', Input::get('species'))->first();

		$headClothing = Clothing::where('species_id', '=', $species->id)->where('type', '=', 'head')->get();

		$headArray = array();

		foreach($headClothing AS $item)
		{
			$headArray[$item->image] = $item->name;
		}

		$accessoryClothing = Clothing::where('species_id', '=', $species->id)->where('type', '=', 'accessory')->get();

		$accessoryArray = array();

		foreach($accessoryClothing AS $item)
		{
			$accessoryArray[$item->image] = $item->name;
		}

		$topClothing = Clothing::where('species_id', '=', $species->id)->where('type', '=', 'top')->get();

		$topArray = array();

		foreach($topClothing AS $item)
		{
			$topArray[$item->image] = $item->name;
		}

		$bottomClothing = Clothing::where('species_id', '=', $species->id)->where('type', '=', 'bottom')->get();

		$bottomArray = array();

		foreach($bottomClothing AS $item)
		{
			$bottomArray[$item->image] = $item->name;
		}

		$response['head'] = $headArray;
		$response['accessory'] = $accessoryArray;
		$response['top'] = $topArray;
		$response['bottom'] = $bottomArray;
		
		if($species->horns)
		{
		    $horns = ColorsAvailable::where('type', '=', 'horns')->get();
		    
		    $hornArray = array();

    		foreach($horns AS $horn)
    		{
    			$hornArray[$horn->color->name] = ucfirst($horn->color->name);
    			
    			if($species->horns_pointed)
    		    {
    		        $hornArray[$horn->color->name.'_pointed'] = ucfirst($horn->color->name).' (Pointed)';
    		    }
    		}

		    
		    $response['horns'] = $hornArray;
		}

		// Return response to demo
		return Response::json($response);
	}
}