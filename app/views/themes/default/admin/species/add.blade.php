@extends('themes.default.layout')

@section('content')
	    <div class="align-center">
        <h1>Species</h1>
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
		<a href="/admin/species/new" class="btn btn-success">Add Species</a>
	</div>

	<div class="row">
		<div class="col-md-12" style="margin-top: 20px; text-align: center;">
			{{ Form::open() }}
				<p>
					{{ Form::label('name', 'Name:') }}
					{{ Form::text('name') }}
				</p>
				
				<p>
				    {{ Form::label('bloodline_id', 'Bloodline:') }}
				    <select name="bloodline_id">
				        @foreach($bloodlines AS $line)
				            <option value="{{ $line->id }}">{{ ucfirst($line->name) }}</option>
				        @endforeach
				    </select>
				</p>
				
				<p>
				    <input type="checkbox" name="horns" value="1" /> Horns?
				</p>
                
                <p>
				    <input type="checkbox" name="horns_pointed" value="1" /> Pointed?
				</p>
				
				<p>
				    <input type="checkbox" name="promo" value="1"> Promo?
				</p>

				<p>
					{{ Form::submit('Create Species!', array('class' => 'btn btn-primary')) }}
				</p>
			{{ Form::close() }}
		</div>
	</div>
@stop