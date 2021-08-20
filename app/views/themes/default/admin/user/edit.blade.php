@extends('themes.default.layout')

@section('content')
	<div class="align-center">
        <h1>Users</h1>
    </div>
    
	<div class="row">
          <div class="col-md-12">
            <div class="well">
              <ul class="nav nav-pills nav-stacked">
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin"  class="btn btn-primary">Dashboard</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/user"  class="btn btn-primary">Users</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/colors"  class="btn btn-primary">Colors</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/species"  class="btn btn-primary">Species</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/craviary"  class="btn btn-primary">Craviary</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/species/upload"  class="btn btn-primary">Species Image Upload</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/clothing/upload"  class="btn btn-primary">Clothing Image Upload</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/beta-codes"  class="btn btn-primary">Beta Codes</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/bloodlines"  class="btn btn-primary">Bloodlines</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/promo-codes"  class="btn btn-primary">Promo Codes</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/items"  class="btn btn-primary">Items</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/items/categories"  class="btn btn-primary">Categories</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/shops"  class="btn btn-primary">Shops</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/npcs"  class="btn btn-primary">Npcs</a></li>
                <li style="margin-left: 5px; margin-bottom: 5px;"><a href="/admin/forums"  class="btn btn-primary">Forums</a></li>
              </ul>
            </div>
          </div>
          
    </div>
	<div class="row">
		<div class="col-md-12" style="margin-top: 20px; text-align: center;">
			{{ Form::model($user) }}
				<p>
					{{ Form::label('username', 'Username:') }}
					{{ Form::text('username', $user->username) }}
				</p>
				
				<p>
					{{ Form::label('password', 'Password:') }}
					{{ Form::password('password') }}
				</p>
				
				<p>
					{{ Form::label('passwordConfirm', 'Password Confirm:') }}
					{{ Form::password('passwordConfirm') }}
				</p>

				<p>
					{{ Form::label('addRole', 'Add Role:') }}
					{{ Form::select('addRole', $roleArray) }}
				</p>

				<p>
					<center>
						<strong>Current Roles (Select to Delete!)</strong>
						<table class="table table-bordered" style="width: 300px;">
							<thead>
								<tr>
									<th class="col-md-1"></th>
									<th class="col-md-2">Role</th>
								</tr>
							</thead>

							<tbody>
								@foreach($userRoles AS $role)
									<tr>
										<td>{{ Form::checkbox('role[]', $role->id) }}</td>
										<td>{{ $role->name }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</center>
				</p>

				{{ Form::hidden('id', $user->id) }}

				<p>
					{{ Form::submit('Edit!', array('class' => 'btn btn-primary')) }}
				</p>
			{{ Form::close() }}

			<p style="margin-top: 40px;">
				<center>
					<strong>User Logins</strong>
					<table class="table table-bordered" style="width: 600px;">
						<thead>
							<tr>
								<th style="width: 40%;">IP Address</th>
								<th style="width: 60%;">Date & Time</th>
							</tr>
						</thead>

						<tbody>
							@foreach($userLogin AS $log)
								<tr>
									<td>{{ $log->ip }}</td>
									<td>{{ $log->created_at }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</center>
			</p>
		</div>
	</div>
@stop