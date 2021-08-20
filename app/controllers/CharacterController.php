<?php

class CharacterController extends BaseController {
	
	public function __construct()
	{
		$this->beforeFilter('csrf', array('on' => 'post'));
	}
	
	public function getProfile($id)
	{

        $character = UserCharacters::where('id', '=', $id)->withTrashed()->first();
        $data['character'] = $character;
        
		return View::make($this->layout.'.character.profile', $data);
	}
	
	public function getDelete($id)
	{
	    $character = UserCharacters::where('id', '=', $id)->withTrashed()->first();
	    
        if($character->user_id != Auth::user()->id || $character->deleted_at && strtotime($character->deleted_at) <= strtotime("-72 Hours"))
        {
            return Redirect::to('/character/profile/'.$id);
        }
        
        if(!$character->deleted_at)
        {
            $character->delete();
        }
        else
        {
            $character->restore();
        }
        
        return Redirect::to('/character/profile/'.$id);
	}
}