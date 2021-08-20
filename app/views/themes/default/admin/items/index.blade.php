@extends('themes.default.layout')

@section('content')
    <div class="align-center">
        <h1>Items</h1>
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
		<a href="/admin/items/new" class="btn btn-success">New</a>
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
						<th style="width: 10%;">Category</th>
						<th style="width: 10%;">Price</th>
						<th style="width: 40%;" colspan="2">Description</th>
						<th style="width: 10%;">Options</th>
					</tr>
				</thead>

				<tbody>
					@foreach($items AS $item)
						<tr>
							<td>{{ $item->id }}</td>
							<td><img src="/assets/images/items/{{ $item->image }}" /></td>
							<td>{{ $item->name }}</td>
							<td>{{ $item->category->name }}</td>
							<td>{{ $item->sell_price }}</td>
							<td colspan="2">
							    {{ $item->description }}
							</td>
							<td>
								<a href="/admin/items/edit/{{ $item->id }}" class="btn btn-warning">Edit</a>
								<a href="/admin/items/delete/{{ $item->id }}" class="btn btn-danger">Delete</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop