<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function roles()
	{
		$roles = Roles::get();

		$userRoles = array();

		foreach($roles as $info)
		{
			$getRole = UserRoles::where('user_id', '=', $this->id)->where('role_id', '=', $info->id)->get();

			if($getRole->count())
			{
				$userRoles[$info->name] = TRUE;
			}
			else
			{
				$userRoles[$info->name] = FALSE;
			}
		}

		return $userRoles;
	}
	
	// Item Check
	public function hasItem($itemId, $amount = 1) {
	    
	    if(!$this->items()->where('item_id', '=', $itemId)->where('qty', '>=', $amount)->count())
	    {
		    return false;
	    }
	    else
	    {
	        return true;
	    }
    }
	
	// Give Item to user
	public function giveItem($itemId, $amount = 1) {
	    
	    if(!$this->items()->where('item_id', '=', $itemId)->count())
	    {
		    $item = new UserItems;
		    $item->user_id = $this->id;
		    $item->item_id = $itemId;
		    $item->qty = 1;
		    $item->save();
	    }
	    else
	    {
	        $item = $this->items()->where('item_id', '=', $itemId)->first();
	        $item->increment('qty');
	        $item->save();
	    }
    }
    
    // Take Item from user
	public function takeItem($itemId, $amount = 1) {
	    
	        $item = $this->items()->where('item_id', '=', $itemId)->first();
	        
	        if(($item->qty - $amount) > $amount)
	        {
	            $item->decrement('qty', $amount);
	            $item->save();
	        }
	        else
	        {
	            $item->delete();
	        }

    }
	
	// Give Currency to user
	public function giveCurrency($type, $amount) {
		if($type == 'silver')
		{
        	$this->increment('silver', $amount);
        	$this->save();
       	}
        elseif($type == 'gold')
        {
            $this->increment('gold', $amount);
            $this->save();
        }
    }

    // Take Currency from user
    public function takeCurrency($type, $amount) {
        if($type == 'silver' && $this->silver >= $amount)
        {
            $this->decrement('silver', $amount);
            $this->save();

            return true;
        }
        elseif($type == 'gold' && $this->gold >= $amount)
        {
            $this->decrement('gold', $amount);
            $this->save();

            return true;
        }
        else
        {
            return false;
        }
    }
    
    // Check inventory space
	public function invSpace() {
		if($this->items()->count() < ($this->inventory_size * 50))
		{
		    return true;
		}
		else
		{
		    return false;
		}
    }

	
	public function characters() {
        return $this->hasMany('UserCharacters', 'user_id'); 
    }
    
    public function activeCharacter() {
        return $this->hasOne('UserCharacters', 'id', 'active_character'); 
    }
    
    public function items() {
        return $this->hasMany('UserItems', 'user_id'); 
    }
    
    public function bonds() {
        return $this->hasMany('UserBonds', 'user_id'); 
    }
    
    public function threads() {
        return $this->hasMany('ForumThreads', 'user_id'); 
    }
    
    public function posts() {
        return $this->hasMany('ForumReplies', 'user_id'); 
    }
    
    public function allies() {
        return $this->hasMany('Allies', 'user_id')->where('status', '=', 1); 
    }
    
    public function alliesPending() {
        return $this->hasMany('Allies', 'user_id')->where('status', '=', 0); 
    }
}
