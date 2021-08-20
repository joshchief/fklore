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
		<div class="col-md-12">
			<br />
			<table class="table table-bordered">
				<thead>
					<tr>
						<th style="width: 10%;">Id</th>
						<th style="width: 30%;">Username</th>
						<th style="width: 20%;">Status</th>
						<th style="width: 40%;">Options</th>
					</tr>
				</thead>

				<tbody>
					@foreach($users AS $user)
						<tr>
							<td>{{ $user->id }}</td>
							<td>{{ $user->username }}</td>
							<td>
								@if($user->active == 0)
								<span class="label label-danger">
									Disabled
								@elseif($user->active == 1)
								<span class="label label-success">
									Active
								@endif
								</span>
							</td>
							<td>
								<a href="/admin/user/edit/{{ $user->id }}" class="btn btn-primary">Edit</a>

								@if($user->active == 0)
									<a href="/admin/user/enable/{{ $user->id }}" class="btn btn-success">Enable</a>
								@else
									<a href="/admin/user/disable/{{ $user->id }}" class="btn btn-warning">Disable</a>
								@endif
								
								<a href="/admin/user/delete/{{ $user->id }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12" style="text-align: center;">
	        <a href="/admin/user/reset-all" class="btn btn-danger" onclick="return confirm('Are you sure you want to reset the user database table?');">Reset User Database Table</a>
	    </div>
	</div>
@stop