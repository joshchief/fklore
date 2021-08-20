<?php

class IndexController extends BaseController {

    
	public function getIndex()
	{
		return View::make($this->layout.'.index');
	}
	
	public function getNews()
	{
	    $forum = ForumCategories::find(1);
	    
	    $news = $forum->threads()->paginate(25);
	    
	     $data = array(
			'news' => $news,
		);
	    
		return View::make($this->layout.'.news', $data);
	}
	
	public function getTown()
	{
		return View::make($this->layout.'.town');
	}
	
	
	public function getTos()
	{
		return View::make($this->layout.'.tos');
	}
	
	public function getCredits()
	{
		return View::make($this->layout.'.credits');
	}
	
		public function getRules()
	{
		return View::make($this->layout.'.rules');
	}
	
		public function getStaff()
	{
		return View::make($this->layout.'.staff');
	}
	
	public function getCreate()
	{
	    $race = Bloodlines::all();
	    
	    $data = array(
			'race' => $race,
		);
	    
		return View::make($this->layout.'.create', $data);
	}
	
	public function getCreateNext($species)
	{
	    $species = Species::where('name', '=', strtolower($species))->first();
	    
	    $skins = ColorsAvailable::where('type', '=', 'skin')->where('creation', '=', 1)->get();
		$eyes = ColorsAvailable::where('type', '=', 'eyes')->where('creation', '=', 1)->get();
		
		if($species->horns || $species->horns_pointed)
		{
		    $horns = ColorsAvailable::where('type', '=', 'horns')->where('creation', '=', 1)->get();
		}
		else
		{
		    $horns = false;
		}
	    
	    $data = array(
			'species' => $species,
			'skins' => $skins,
			'eyes' => $eyes,
			'horns' => $horns,
		);
	    
		return View::make($this->layout.'.create_next', $data);
	}
	
	public function postCreateNext($species)
	{
	    $iSpecies = Input::get('species');
	    $iName = Input::get('name');
	    $iPromo = Input::get('promo');
		$iSkin = Input::get('skin');
		$iEyes = Input::get('eyes');
		$iHorns = Input::get('horns');
		$iHorn_color = Input::get('horn_color');
		
	    $species = Species::where('name', '=', strtolower($species))->first();
	    
	    $skins = ColorsAvailable::where('type', '=', 'skin')->where('creation', '=', 1)->get();
		$eyes = ColorsAvailable::where('type', '=', 'eyes')->where('creation', '=', 1)->get();
		
		if($species->horns || $species->horns_pointed)
		{
		    $horns = ColorsAvailable::where('type', '=', 'horns')->where('creation', '=', 1)->get();
		}
		else
		{
		    $horns = false;
		}

		// Set base img path
		$basePath = '/home/g9capif4d3p3/public_html/public/assets/images/base/'.$iSpecies.'/';

		$image = Image::canvas(800, 800);
	
		$skinImg = Image::make($basePath.'skin/'.$iSkin.'.png');
		
		if($iHorns)
		{
		    if($iHorns == 'normal')
		    {
		        $hornsImg = Image::make($basePath.'horns/'.$iHorn_color.'.png');
		    }
		    else
		    {
		        $hornsImg = Image::make($basePath.'horns/'.$iHorn_color.'_pointed.png');
		    }
		}
		
		$eyesImg = Image::make($basePath.'eyes/'.$iEyes.'.png');

		$image->insert($skinImg);
		
		if($iHorns)
		{
		    $image->insert($hornsImg);
		}
		
		$image->insert($eyesImg);

	

		$image = (string) $image->encode('data-url');
	    
	    $data = array(
			'species' => $species,
			'skins' => $skins,
			'eyes' => $eyes,
			'horns' => $horns,
			'iSpecies' => $iSpecies,
			'iName' => $iName,
			'iPromo' => $iPromo,
			'iSkin' => $iSkin,
			'iEyes' => $iEyes,
			'iHorns' => $iHorns,
			'iHorn_color' => $iHorn_color,
			'image' => $image
		);
	    
		return View::make($this->layout.'.create_next', $data);
	}
	
	public function postCreateFinal()
	{
	    $species = Input::get('species');
	    $name = Input::get('name');
	    $promo = Input::get('promo');
		$skin = Input::get('skin');
		$eyes = Input::get('eyes');
		$horns = Input::get('horns');
		$horn_color = Input::get('horn_color');
		
	    // Check if name is available
	    /*if(UserCharacters::where('name', '=', $name)->count() == 1)
	    {
	        // Redirect with error
	        return Redirect::back()
				->with('nameError', 'This name has already been taken.')
				->withInput();
	    }*/
	    
	    // Check if promo is valid
	    $speciesData = Species::where('name', '=', strtolower($species))->first();
	    
	    $speciesId = $speciesData->id;
	        
	        
	    if($promo && SpeciesPromo::where('code', '=', $promo)->where('species_id', '=', $speciesId)->count() == 1)
	    {
            // See if code is already used
	        if(UserCharacters::where('promo', '=', $promo)->count() == 1)
	        {
	            // Redirect with error
    	        return Redirect::back()
    				->with('promoError', 'This code has already been redeemed!')
    				->withInput();
	        }
	    }
	    elseif($speciesData->promo)
	    {
	        // Redirect with error
	        return Redirect::back()
				->with('promoError', 'Invalid Code!')
				->withInput();
	    }

		// Set base img path
		$basePath = '/home/g9capif4d3p3/public_html/public/assets/images/base/'.$species.'/';

		$image = Image::canvas(800, 800);
	
		$skinImg = Image::make($basePath.'skin/'.$skin.'.png');
		
		if($horns)
		{
		    if($horns == 'normal')
		    {
		        $hornsImg = Image::make($basePath.'horns/'.$horn_color.'.png');
		    }
		    else
		    {
		        $hornsImg = Image::make($basePath.'horns/'.$horn_color.'_pointed.png');
		    }
		}
		
		$eyesImg = Image::make($basePath.'eyes/'.$eyes.'.png');
		//$lineart = Image::make($basePath.'lineart.png');
    
		$image->insert($skinImg);
		
		if($horns)
		{
		    $image->insert($hornsImg);
		}
		
		$image->insert($eyesImg);
		//$image->insert($lineart);

	

		$customImg = (string) $image->encode('data-url');
		
		$data = array(
		    'customImg' => $customImg,
			'species' => $species,
			'name' => $name,
			'skin' => $skin,
			'eyes' => $eyes,
			'promo' => $promo,
			'horns' => $horns,
			'horn_color' => $horn_color,
		);
		
		return View::make($this->layout.'.create_final', $data);
	}
	
	public function postCreateConfirm()
	{
	    $species = Input::get('species');
	    $name = Input::get('name');
	    $promo = Input::get('promo');
		$skin = Input::get('skin');
		$eyes = Input::get('eyes');
		$horns = Input::get('horns');
		$horn_color = Input::get('horn_color');
		$element = Input::get('element');
		
	    // Check if name is available
	    /*if(UserCharacters::where('name', '=', $name)->count() == 1)
	    {
	        // Redirect with error
	        return Redirect::back()
				->with('nameError', 'This name has already been taken.')
				->withInput();
	    }*/

		// Set base img path
		$basePath = '/home/g9capif4d3p3/public_html/public/assets/images/base/'.$species.'/';

		$image = Image::canvas(800, 800);
	
		$skinImg = Image::make($basePath.'skin/'.$skin.'.png');
		
		if($horns)
		{
		    if($horns == 'normal')
		    {
		        $hornsImg = Image::make($basePath.'horns/'.$horn_color.'.png');
		    }
		    else
		    {
		        $hornsImg = Image::make($basePath.'horns/'.$horn_color.'_pointed.png');
		    }
		}
		
		$eyesImg = Image::make($basePath.'eyes/'.$eyes.'.png');
		//$lineart = Image::make($basePath.'lineart.png');
    
		$image->insert($skinImg);
		
		if($horns)
		{
		    $image->insert($hornsImg);
		}
		
		$image->insert($eyesImg);
		//$image->insert($lineart);

	

		$customImg = (string) $image->encode('data-url');
		
		$data = array(
		    'customImg' => $customImg,
			'species' => $species,
			'name' => $name,
			'promo' => $promo,
			'element' => $element,
			'skin' => $skin,
			'eyes' => $eyes,
			'horns' => $horns,
			'horn_color' => $horn_color,
		);
		
		return View::make($this->layout.'.create_confirm', $data);
	}
	
	public function postCreateComplete()
	{
		$species = Input::get('species');
		$name = Input::get('name');
		$promo = Input::get('promo');
		$skin = Input::get('skin');
		$eyes = Input::get('eyes');
		$horns = Input::get('horns');
		$horn_color = Input::get('horn_color');
		$element = Input::get('element');

		// Set base img path
		$basePath = '/home/g9capif4d3p3/public_html/public/assets/images/base/'.$species.'/';

		$image = Image::canvas(800, 800);
	
		$skinImg = Image::make($basePath.'skin/'.$skin.'.png');
		
		if($horns)
		{
		    if($horns == 'normal')
		    {
		        $hornsImg = Image::make($basePath.'horns/'.$horn_color.'.png');
		    }
		    else
		    {
		        $hornsImg = Image::make($basePath.'horns/'.$horn_color.'_pointed.png');
		    }
		}
		
		$eyesImg = Image::make($basePath.'eyes/'.$eyes.'.png');

		$image->insert($skinImg);
		
		if($horns)
		{
		    $image->insert($hornsImg);
		}
		
		$image->insert($eyesImg);
		
		// Final image path
		$finalPath = '/home/g9capif4d3p3/public_html/public/assets/images/characters/';
		
		
		$species = Species::where('name', '=', strtolower($species))->first()->id;
		$skin = Colors::where('name', '=', strtolower($skin))->first()->id;
		$eyes = Colors::where('name', '=', strtolower($eyes))->first()->id;
		
		if($horns)
		{
		    $horn_color = Colors::where('name', '=', strtolower($horn_color))->first()->id;
		}

		// Create character
		$character = new UserCharacters;
		$character->user_id = Auth::user()->id;
		$character->name = $name;
		$character->species_id = $species;
		$character->promo = $promo;
		$character->skin_id = $skin;
        $character->eyes_id = $eyes;
        
        if($horns)
		{
            $character->horn_type = ($horns == 'normal') ? 1 : 2;
            $character->horn_color = $horn_color;
		}
		else
		{
		    $character->horn_type = 0;
            $character->horn_color = 0;
		}
		
        // Generate stats
        $stats = array(
                'mag' => 0,
                'str' => 0,
                'def' => 0,
                'dex' => 0,
                'vit' => 0,
                'agi' => 0,
            );
            
        $points = 20;
        
        switch ($species) {
          case 1:
              
            // Generate special stats
            $agiPoints = mt_rand(6, 14);
            $stats['agi'] = $agiPoints;
            $points = ($points - $agiPoints);
            
            $dexPoints = mt_rand(4, $points);
            $stats['dex'] = $dexPoints;
            $points = ($points - $dexPoints);
            
            foreach($stats AS $stat => $num){
                if($stat != 'agi' && $stat != 'dex')
                {
                    if($points > 0)
                    {
                        $rand = ($points >= 3) ? mt_rand(0, 3) : mt_rand(0, $points);
                        
                        $stats[$stat] = $rand;
                        
                        $points = ($points - $rand);
                    }
                    else
                    {
                        break;
                    }
                }
            }
            break;
          case 2:
            // Generate special stats
            $stats['mag'] = 1;
            $stats['agi'] = 1;
            $stats['dex'] = 1;
            $points = ($points - 3);
            
            $strPoints = mt_rand(5, 15);
            $stats['str'] = $strPoints;
            $points = ($points - $strPoints);
            
            
            
            foreach($stats AS $stat => $num){
                if($stat != 'mag' && $stat != 'agi' && $stat != 'dex' && $stat != 'str')
                {
                    if($points > 0)
                    {
                        $rand = mt_rand(0, $points);
                        
                        $stats[$stat] = $rand;
                        
                        $points = ($points - $rand);
                    }
                    else
                    {
                        break;
                    }
                }
            }
            break;
          case 3:
            // Generate special stats
            $magPoints = mt_rand(3, 5);
            $stats['mag'] = $magPoints;
            $points = ($points - $magPoints);
            
            $agiPoints = mt_rand(3, 5);
            $stats['agi'] = $agiPoints;
            $points = ($points - $agiPoints);
            
            $dexPoints = mt_rand(3, 5);
            $stats['dex'] = $dexPoints;
            $points = ($points - $dexPoints);
            
            foreach($stats AS $stat => $num){
                if($stat != 'mag' && $stat != 'agi' && $stat != 'dex')
                {
                    if($points > 0)
                    {
                        if($stat == 'str' && $points > 3)
                        {
                            $rand = mt_rand(1, 2);
                            
                            $stats[$stat] = $rand;
                            
                            $points = ($points - $rand);
                        }
                        
                        if($stat == 'def' && $points > 2)
                        {
                            $rand = mt_rand(1, 2);
                            
                            $stats[$stat] = $rand;
                            
                            $points = ($points - $rand);
                        }
                        
                        if($stat == 'vit' && $points > 1)
                        {
                            $rand = 2;
                            
                            $stats[$stat] = $rand;
                            
                            $points = ($points - $rand);
                        }
                        else
                        {
                            $rand = 1;
                            
                            $stats[$stat] = $rand;
                            
                            $points = ($points - $rand);
                        }
                    }
                    else
                    {
                        break;
                    }
                }
            }
            break;
          case 4:
            // Generate special stats
            $magPoints = mt_rand(5, 18);
            $stats['mag'] = $magPoints;
            $points = ($points - $magPoints);
            
            foreach($stats AS $stat => $num){
                if($stat != 'mag')
                {
                    if($points > 0)
                    {
                        $rand = mt_rand(0, $points);
                        
                        $stats[$stat] = $rand;
                        
                        $points = ($points - $rand);
                    }
                    else
                    {
                        break;
                    }
                }
            }
            break;
          case 5:
            // Generate special stats
            $strPoints = mt_rand(5, 13);
            $stats['str'] = $strPoints;
            $points = ($points - $strPoints);
            
            $defPoints = mt_rand(5, $points);
            $stats['def'] = $defPoints;
            $points = ($points - $defPoints);
            
            foreach($stats AS $stat => $num){
                if($stat != 'mag' && $stat != 'str' && $stat != 'def')
                {
                    if($points > 0)
                    {
                        $rand = mt_rand(0, $points);
                        
                        $stats[$stat] = $rand;
                        
                        $points = ($points - $rand);
                    }
                    else
                    {
                        break;
                    }
                }
            }
            break;
        }
        
        $character->level = 1;
        $character->magic = $stats['mag'];
        $character->strength = $stats['str'];
        $character->defense = $stats['def'];
        $character->dexterity = $stats['dex'];
        $character->vitality = $stats['vit'];
        $character->agility = $stats['agi'];
        $character->element = $element;
        $character->save();
        
        File::makeDirectory($finalPath.$character->id, 0775, true);
        
        $image->save($finalPath.$character->id.'/image.png');
        
        $cropImg = Image::make($finalPath.$character->id.'/image.png');
        
        switch ($species) {
          case 1:
            $cropImg->crop(175, 175, 325, 180);
            
            break;
          case 2:
            $cropImg->crop(175, 175, 325, 65);
            
            break;
          case 3:
            $cropImg->crop(175, 175, 240, 120);
            
            break;
          case 4:
            $cropImg->crop(175, 175, 460, 140);
            
            break;
          case 5:
            $cropImg->crop(175, 175, 60, 425);
            
            break;
        }
        
		$cropImg->save($finalPath.$character->id.'/image_cropped.png');
		
		$user = Auth::user();
	    $user->active_character = $character->id;
	    $user->save();

		// Return 
		return Redirect::to('/character/profile/'.$character->id);
	}
	
	public function postCreateGenerate()
	{
		$species = Input::get('species');
		$skin = Input::get('skin');
		$eyes = Input::get('eyes');
		$horns = Input::get('horns');
		$horn_color = Input::get('horn_color');

		// Set base img path
		$basePath = '/home/g9capif4d3p3/public_html/public/assets/images/base/'.$species.'/';

		$image = Image::canvas(800, 800);
	
		$skinImg = Image::make($basePath.'skin/'.$skin.'.png');
		
		if($horns)
		{
		    if($horns == 'normal')
		    {
		        $hornsImg = Image::make($basePath.'horns/'.$horn_color.'.png');
		    }
		    else
		    {
		        $hornsImg = Image::make($basePath.'horns/'.$horn_color.'_pointed.png');
		    }
		}
		
		$eyesImg = Image::make($basePath.'eyes/'.$eyes.'.png');
		//$lineart = Image::make($basePath.'lineart.png');
    
		$image->insert($skinImg);
		
		if($horns)
		{
		    $image->insert($hornsImg);
		}
		
		$image->insert($eyesImg);
		//$image->insert($lineart);

	

		$response['image'] = (string) $image->encode('data-url');

		// Return response to create
		return Response::json($response);
	}

	public function getDemo()
	{
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

		return View::make($this->layout.'.demo', $data);
	}

	public function postDemoGenerate()
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

	public function postDemoClothes()
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
	
	public function postCharChange()
	{
		$character = Input::get('character');

        // If character belongs to user
        $charCount = Auth::user()->characters()->where('id', '=', $character)->count();
        
	    if($charCount > 0)
	    {
	        $user = Auth::user();
	        $user->active_character = $character;
	        $user->save();
	    }

		$response = true;

		// Return response to create
		return Response::json($response);
	}

}
