<?php

class AdminUserController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex()
	{
		$users = User::select('id', 'username', 'active')->get();

		$data['users'] = $users;

		return View::make($this->layout.'.admin.user.index', $data);
	}

	public function getEdit($id)
	{
		$user = User::where('id', '=', $id)->first();

		$userLogin = UserLogin::where('user_id', '=', $id)->take(10)->get();

		$role = Roles::orderBy('id', 'asc')->get();

		$userRoles = UserRoles::join('roles', 'roles.id', '=', 'user_roles.role_id')
						->where('user_roles.user_id', '=', $id)
						->select('user_roles.id', 'user_roles.role_id', 'roles.name')
						->orderBy('user_roles.id', 'asc')
						->get();

		$roleArray = array('' => '');

		foreach($role AS $info)
		{
			$roleArray[$info->id] = $info->name;
		}

		$data = array(
				'user' => $user,
				'roleArray' => $roleArray,
				'userRoles' => $userRoles,
				'userLogin' => $userLogin
			);
		
		return View::make($this->layout.'.admin.user.edit', $data);
	}

	public function postEdit()
	{
		$id = Input::get('id');
		
		$user = User::where('id', '=', $id)->first();
		
		if(Input::get('username') != $user->username && Input::get('username') != '')
		{
		    $user->username = Input::get('username');
		    $user->save();
		}
		
		if(Input::get('password') != '' && Input::get('password') == Input::get('passwordConfirm'))
		{
		    $user->password = Hash::make(Input::get('password'));
		    $user->save();
		}
		elseif(Input::get('password') != '' && Input::get('password') != Input::get('passwordConfirm'))
		{
		    Session::flash('errors', 'Passwords do not match!');

		    return Redirect::to('admin/user/edit/'.$id);
		}

		if(Input::get('addRole'))
		{
			$count = UserRoles::where('user_id', '=', $id)
							->where('role_id', '=', Input::get('addRole'))
							->count();
			if(!$count)
			{								
				$userRoles = new UserRoles;

				$userRoles->user_id = $id;

				$userRoles->role_id = Input::get('addRole');

				$userRoles->save();
			}
		}

		if(Input::get('role'))
		{
			foreach(Input::get('role') AS $role)
			{
				UserRoles::where('id', '=', $role)->delete();
			}
		}

		Session::flash('success', 'User updated!');

		return Redirect::to('admin/user/edit/'.$id);
	}

	public function getEnable($id)
	{
		$user = User::where('id', '=', $id)->first();

		$user->active = 1;

		$user->save();

		Session::flash('success', 'User successfully enabled!');

		return Redirect::to('admin/user');
	}


	public function getDisable($id)
	{
		$user = User::where('id', '=', $id)->first();

		$user->active = 0;

		$user->remember_token = '';

		$user->save();

		Session::flash('success', 'User disabled successfully!');

		return Redirect::to('admin/user');
	}
	
	public function getDelete($id)
	{
		$user = User::where('id', '=', $id)->first();

		$user->delete();
		
		$max = DB::table('users')->max('id') + 1; 
        DB::statement("ALTER TABLE folk_users AUTO_INCREMENT =  $max");


		Session::flash('success', 'User deleted!');

		return Redirect::to('admin/user');
	}
	
	public function getResetAll()
	{
		User::truncate();
		UserRoles::truncate();
		UserLogin::truncate();


		Session::flash('success', 'All users have been cleared!');

		return Redirect::to('admin/user');
	}
}