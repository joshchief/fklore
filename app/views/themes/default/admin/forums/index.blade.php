@extends('themes.default.layout')

@section('content')
    <div class="align-center">
        <h1>Forums</h1>
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
    
	<div style="text-align: right; margin-top: 20px;">
		<a href="/admin/forums/new" class="btn btn-success">New</a>
	</div>

	<div class="row">
		<div class="col-md-12">
			<br />
			<table class="table table-bordered">
				<thead>
					<tr>
						<th style="width: 10%;">Id</th>
						<th style="width: 10%;">Image</th>
						<th style="width: 20%;">Name</th>
						<th style="width: 30%;" colspan="2">Description</th>
						<th style="width: 10%;">Staff Only</th>
						<th style="width: 10%;">Options</th>
					</tr>
				</thead>

				<tbody>
					@foreach($categories AS $forum)
						<tr>
							<td>{{ $forum->id }}</td>
							<td><img src="/assets/images/forums/{{ $forum->image }}" /></td>
							<td>{{ $forum->name }}</td>
							<td colspan="2">
							    {{ $forum->description }}
							</td>
							<td>{{ ($forum->staff) ? 'Yes' : 'No' }}</td>
							<td>
								<a href="/admin/forums/edit/{{ $forum->id }}" class="btn btn-warning">Edit</a>
								<a href="/admin/forums/delete/{{ $forum->id }}" class="btn btn-danger">Delete</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop