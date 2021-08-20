<?php

class UserController extends BaseController {
	
	public function __construct()
	{
		$this->beforeFilter('csrf', array('on' => 'post'));
	}
	
	public function getWarn($id)
	{
		if(!Auth::check())
		{
			return Redirect::to('/user/login');
		}
		
		$roles = Auth::user()->roles();

		if (!$roles['admin'] && !$roles['moderator'])
		{
			return Redirect::to('/');
		}
		
		$user = User::find($id);
		
		$data['user'] = $user;
        
        return View::make($this->layout.'.user.warn', $data);
	}
	
	public function postWarn($id)
	{
		if(!Auth::check())
		{
			return Redirect::to('/user/login');
		}
		
		$roles = Auth::user()->roles();

		if (!$roles['admin'] && !$roles['moderator'])
		{
			return Redirect::to('/');
		}
		
		// Set form rules
		$rules = array(
			'warning'				=> 'required',
		);

		// Set form error messages
		$messages = array(
			'warning.required'				=> 'You must enter text for the warning!',
		);
		
		// Send input through validator
		$validator = Validator::make(Input::all(), $rules, $messages);

        // If validation fails give error messages
		if($validator->fails())
		{
			return Redirect::to('user/warn/'.$id)
				->with('errors', $validator->messages()->all());
		}
		else
		{
		    $warning = Input::get('warning');
		    
			// Send Notification
            Messages::notify($id, 'You have received an official warning!', $warning, 1);
            
            Session::flash('success', 'Warning sent!');
            
            return Redirect::to('user/warn/'.$id);
		}
	}
	
	public function getAlliance($id)
	{
		if(!Auth::check())
		{
			return Redirect::to('/user/login');
		}
		
		if(Auth::user()->id == $id || Auth::user()->allies()->where('ally_id', '=', $id)->count() || Auth::user()->alliesPending()->where('ally_id', '=', $id)->count())
		{
			return Redirect::to('/user/profile/'.$id);
		}
        
        // Send ally request
        $allyRequest = new Allies;
        $allyRequest->user_id = Auth::user()->id;
        $allyRequest->ally_id = $id;
        $allyRequest->save();
        
        $allyData = new Allies;
        $allyData->user_id = $id;
        $allyData->ally_id = Auth::user()->id;
        $allyData->save();
        
        // Send Notification
        Messages::notify($id, Auth::user()->username. '(#'.Auth::user()->id.') has requested an alliance!', '<center><strong>'.Auth::user()->username. '(#'.Auth::user()->id.') has requested an alliance!</strong> <br /><br /><a href="/user/alliance-accept/'.Auth::user()->id.'" class="btn primary rounded white-font">Accept</a>&nbsp;<a href="/user/alliance-deny/'.Auth::user()->id.'" class="btn btn-danger rounded white-font" onclick="if (! confirm(\'Are you sure you want to end this alliance?\')) { return false; }">Deny</a></center>');
        
		return Redirect::to('/user/profile/'.$id);
	}
	
	public function getAllianceAccept($id)
	{
		if(!Auth::check())
		{
			return Redirect::to('/user/login');
		}
		
		if(!Auth::user()->alliesPending()->where('ally_id', '=', $id)->count())
		{
		    return Redirect::to('/user/messages');
		}
		
		// Update ally data
        $allyPending = Auth::user()->alliesPending()->where('ally_id', '=', $id)->first();
        $allyPending->status = 1;
        $allyPending->save();
        
        $allies = Allies::where('ally_id', '=', Auth::user()->id)->where('user_id', '=', $id)->first();
        $allies->status = 1;
        $allies->save();
        
        // Send Notification
        Messages::notify($id, Auth::user()->username. '(#'.Auth::user()->id.') has accepted your alliance!', '<center>'.Auth::user()->username. '(#'.Auth::user()->id.') has accepted your alliance!</center>');
        
		return Redirect::to('/user/messages');
	}
	
	public function getAllianceDeny($id)
	{
		if(!Auth::check())
		{
			return Redirect::to('/user/login');
		}
		
		if(!Auth::user()->alliesPending()->where('ally_id', '=', $id)->count())
		{
		    return Redirect::to('/user/messages');
		}
		
		// Delete ally data
        Auth::user()->alliesPending()->where('ally_id', '=', $id)->delete();
        Allies::where('ally_id', '=', Auth::user()->id)->where('user_id', '=', $id)->delete();
        
        // Send Notification
        Messages::notify($id, Auth::user()->username. '(#'.Auth::user()->id.') has denied your alliance!', '<center>'.Auth::user()->username. '(#'.Auth::user()->id.') has denied your alliance!</center>');
        
		return Redirect::to('/user/messages');
	}
	
	
	public function getAllianceEnd($id)
	{
		if(!Auth::check())
		{
			return Redirect::to('/user/login');
		}
		
		if(Auth::user()->id == $id)
		{
			return Redirect::to('/user/profile/'.$id);
		}
        
        // Delete ally data
        Auth::user()->allies()->where('ally_id', '=', $id)->delete();
        Allies::where('ally_id', '=', Auth::user()->id)->where('user_id', '=', $id)->delete();
        
		return Redirect::to('/user/profile/'.$id);
	}
	
	public function getProfile($id)
	{
		if(!Auth::check())
		{
			return Redirect::to('/user/login');
		}

        $user = User::find($id);
        $data['user'] = $user;
        
		return View::make($this->layout.'.user.profile', $data);
	}
	
	public function getInventory()
	{
		if(!Auth::check())
		{
			return Redirect::to('/user/login');
		}

        $userItems = Auth::user()->items()->paginate(18);
        
        $data['items'] = $userItems;
        
		return View::make($this->layout.'.user.inventory', $data);
	}
	
	// DISPLAY REGISTER FORM -----------------------------------------------------------
	public function getRegister()
	{
		if(Auth::check())
		{
			return Redirect::to('/');
		}

		return View::make($this->layout.'.user.register');
	}

	// PROCESS REGISTER -----------------------------------------------------------
	public function postRegister()
	{
		if(Auth::check())
		{
			return Redirect::to('/');
		}

		// Set form rules
		$rules = array(
			'username'				=> 'required|max:12|alpha_dash|unique:users',
			'password' 				=> 'required|min:15',
			'passwordConfirm' 		=> 'required|same:password',
			'email' 				=> 'required|email',
			'month' 				=> 'required',
			'day' 					=> 'required',
			'year' 					=> 'required',
			'referrer' 				=> 'exists:users,username',
			'beta' 					=> 'required|exists:beta,code',
			//'terms' 				=> 'required',
			//'g-recaptcha-response'  => 'required',
		);

		// Set form error messages
		$messages = array(
			'username.required'				=> 'You must enter a username!',
			'username.max'					=> 'Username can only have 12 characters max!',
			'username.alpha_dash'			=> 'Username must be must be Alphanumeric but can also include dashes or underscores!',
		    'username.unique'				=> 'Username already taken!',
		    'password.required'     		=> 'You must enter a password!',
		    'password.min'      			=> 'Password must be at least 15 characters!',
		    'passwordConfirm.required'      => 'You must confirm your password!',
		    'passwordConfirm.same'      	=> 'Passwords do not match!',
		    'email.required'    			=> 'You must enter your email address!',
		    'email.email' 					=> 'You must enter a valid email!',
		    'referrer.exists'  				=> 'Referrer does not exist!',
		    'beta.required'				    => 'A Beta Code is needed in order to register!',
		    'beta.exists'				    => 'Beta code invalid!',
		    //'terms.required'				=> 'You must accept our Terms!',
		    //'g-recaptcha-response.required' => 'Captcha verification has failed!',
		);
		
		// Send input through validator
		$validator = Validator::make(Input::all(), $rules, $messages);

		// Convert birthday to time
		$birthday = strtotime(Input::get('year').'-'.Input::get('month').'-'.Input::get('day'));

		if(strtotime("+16 years", $birthday) < time() && !Request::cookie('access'))
		{
			// If validation fails give error messages
			if($validator->fails())
			{
				return Redirect::to('user/register')
				->with('errors', $validator->messages()->all())
				->withInput(Input::except('password'), Input::except('passwordConfirm'));
			}
			else
			{
			    $emailCheck = User::where('email', '=', Purifier::clean(Input::get('email')))->count();
			    
			    if($emailCheck >= 2)
			    {
			        return Redirect::to('user/register')
    				->with('errors', 'There are already the max of 2 accounts using this email!')
    				->withInput(Input::except('password'), Input::except('passwordConfirm'));
			    }
			    
				$birthday = Input::get('year').'-'.Input::get('month').'-'.Input::get('day');

				// Create new user
				$user = new User;
				
				$code = Beta::where('code', '=', Purifier::clean(Input::get('beta')))->first();
				
				$takenIds = Beta::lists('account');
				
				if($code->account)
				{
				    $user->id = (int) $code->account;
				}
				else
				{
				    $users = User::lists('id');
				    
				    for($i = 1; $i++;)
				    {
				        if(!in_array($i, $takenIds) && !in_array($i, $users))
				        {
				                $user->id = (int) $i;
				                break;
				        }
				        
				    }
				}
				
				$user->username = Purifier::clean(Input::get('username'));
				$user->ip = $_SERVER['REMOTE_ADDR'];
				$user->email = Purifier::clean(Input::get('email'));
				$user->password = Hash::make(Input::get('password'));
				$user->birthday = $birthday;
				$user->referrer = Purifier::clean(Input::get('referrer'));
				$user->beta_code = Purifier::clean(Input::get('beta'));
				$user->last_login = date('Y-m-d H:i:s');
				$user->last_active = time();
				$user->save();
				
				// Delete beta code
				$beta = Beta::where('code', '=', Input::get('beta'))->delete();
				
				$max = DB::table('beta')->max('id') + 1; 
                DB::statement("ALTER TABLE folk_beta AUTO_INCREMENT =  $max");

				$userdata = array(
					'username' => Input::get('username'),
					'password' => Input::get('password'),
				);

				// Log user in
				Auth::attempt($userdata, true);

				// Give "User" role
				$userRoles = new UserRoles;
				$userRoles->user_id = $user->id;
				$userRoles->role_id = 2;
				$userRoles->save();

				if(Auth::attempt($userdata))
				{
					$userLogin = new UserLogin;
					$userLogin->user_id = $user->id;
					$userLogin->ip = $_SERVER['REMOTE_ADDR'];
					$userLogin->save();

					return Redirect::intended('/');
				} else {
					return Redirect::to('user/login');
				}
				//Session::put('success', 'Thank you for registering for FolkOfLore!');
				//return Redirect::intended('/user/register');
			}
		}
		elseif(!Cookie::get('access'))
		{
			$cookie = Cookie::forever('access', 1);

			return Redirect::to('/user/register')->withCookie($cookie);
		}

		// Redirect to register page
		return Redirect::to('/user/register');
	}

	// DISPLAY LOGIN FORM -----------------------------------------------------------
	public function getLogin()
	{
		if(Auth::check())
		{
			return Redirect::to('/');
		}

		return View::make($this->layout.'.user.login');
	}

	// PROCESS LOGIN -----------------------------------------------------------
	public function postLogin()
	{
		if(Auth::check())
		{
			return Redirect::to('/');
		}
		
		// Set form rules
		$rules = array(
			'username'				=> 'required|exists:users,username',
			'password' 				=> 'required',
		);

		// Set form error messages
		$messages = array(
			'username.required'				=> 'You must enter a username!',
			'username.exists'				=> 'Invalid username!',
		    'password.required'     		=> 'You must enter a password!'
		);
		
		// Send input through validator
		$validator = Validator::make(Input::all(), $rules, $messages);

		// If validation fails give error messages
		if($validator->fails())
		{
			return Redirect::to('user/login')
				->with('errors', $validator->messages()->all())
				->withInput(Input::except('password'));
		}
		else
		{
			$userdata = array(
				'username' => Input::get('username'),
				'password' => Input::get('password'),
			);

			if(Auth::attempt($userdata, true))
			{
				$user = User::where('username', '=', Auth::user()->username)->first();
				$user->last_login = date('Y-m-d H:i:s');
				$user->save();

				$userLogin = new UserLogin;
				$userLogin->user_id = $user->id;
				$userLogin->ip = $_SERVER['REMOTE_ADDR'];
				$userLogin->save();

				return Redirect::intended('/');
			}
			else
			{
				return Redirect::to('user/login')
					->with('errors', 'Invalid Username and Password Combination!')
					->withInput(Input::except('password'));
			}
		}
	}

	// LOGOUT -----------------------------------------------------------
	public function getLogout()
	{
		// Log user out
		Auth::logout();

		// Redirect to index
		return Redirect::to('/');
	}
	
	// DISPLAY PASSWORD RESET -----------------------------------------------------------
	public function getReset($token = NULL)
	{
		if(Auth::check())
		{
			return Redirect::to('/');
		}

		if(!$token)
		{
			return View::make($this->layout.'.user.reset');
		}
		else
		{
			// See if token exists in the database
			$tokenCount = User::where('reset_token', '=', $token)->count();

			// If token doesn't exsist then redirect to pasword reset
			if(!$tokenCount)
			{
				return Redirect::to('user/reset');
			}

			// Get username of the account we are resetting the password for
			$data['username'] = User::where('reset_token', '=', $token)->select('username')->first()->username;
			$data['token'] = $token;

			return View::make($this->layout.'.user.reset_token', $data);
		}
	}

	// PROCESS PASSWORD RESET -----------------------------------------------------------
	public function postReset($token = NULL)
	{
		if(Auth::check())
		{
			return Redirect::to('/');
		}

		if(!$token)
		{
			// Set form rules
			$rules = array(
				'userReset'	=> 'required|exists:users,username'
			);

			// Set form error messages
			$messages = array(
				'userReset.required' => 'You must enter a username!',
				'userReset.exists'	 => 'Invalid username!'
			);
			
			// Send input through validator
			$validator = Validator::make(Input::all(), $rules, $messages);

			// Array that will hold our error messages
			$msgArray = array();

			// If validation fails give error messages
			if($validator->fails())
			{
				// Get our error messages
				$messages = $validator->messages();

				// See if there are any errors with the username
				if($messages->has('userReset'))
				{
					// Add first issue to our $msgArray
					$msgArray['username'] = $messages->first('userReset');
				}

				return Redirect::to('user/reset')
					->with('errors', $msgArray)
					->withInput();
			}
			else
			{
				// Generate reset token
				$resetToken = str_random(80);

				// Get user info and add reset token
				$user = User::where('username', '=', Input::get('userReset'))->first();
				$user->reset_token = $resetToken;
				$user->save();


				// Send reset token to users email
				$email = $user->email;

				$data = array(
					'username' => $user->username,
					'resetToken' => $user->reset_token
				);

				Mail::send('emails.reset',  $data, function($message) use ($email)
				{
					$message->to($email)->subject('FolkOfLore.com - Reset your password!');
				});

				Session::flash('success', 'Instructions on how to reset your password have been sent to the email on file!');
			}
		}
		else
		{
			// See if token exists in the database
			$tokenCount = User::where('reset_token', '=', $token)->count();

			// If token doesn't exsist then redirect to pasword reset
			if(!$tokenCount)
			{
				return Redirect::to('user/reset');
			}

			// Set form rules
			$rules = array(
				'password' 				=> 'required|min:6',
				'passwordConfirm' 		=> 'required|same:password',
			);

			// Set form error messages
			$messages = array(
			    'password.required'     		=> 'You must enter a password!',
			    'password.min'      			=> 'Password must be at least 6 characters!',
			    'passwordConfirm.required'      => 'You must confirm your password!',
			    'passwordConfirm.same'      	=> 'Passwords do not match!'
			);
			
			// Send input through validator
			$validator = Validator::make(Input::all(), $rules, $messages);

			// Array that will hold our error messages
			$msgArray = array();

			// If validation fails give error messages
			if($validator->fails())
			{
				// Get our error messages
				$messages = $validator->messages();

				// See if there are any errors with the password
				if($messages->has('password'))
				{
					// Add first issue to our $msgArray
					$msgArray['password'] = $messages->first('password');
				}

				// See if there are any errors with the password confirmation
				if($messages->has('passwordConfirm'))
				{
					// Add first issue to our $msgArray
					$msgArray['passwordConfirm'] = $messages->first('passwordConfirm');
				}

				return Redirect::to('user/reset/'.$token)
					->with('errors', $msgArray);
			}
			else
			{
				// Change the users password and remove reset token
				$user = User::where('reset_token', '=', $token)->first();
				$user->password = Hash::make(Input::get('password'));
				$user->reset_token = '';
				$user->save();

				// Set success message
				Session::flash('success', 'Your password has been reset!');

				// Redirect to login page
				return Redirect::to('/user/login');
			}
		}

		// Redirect to reset page
		return Redirect::to('/user/reset');
	}
}
