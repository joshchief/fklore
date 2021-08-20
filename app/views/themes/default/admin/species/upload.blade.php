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
			{{ Form::open(array('url' => '/admin/species/upload', 'method' => 'post', 'files' => true)) }}
			    <p>
			        {{ Form::label('image', 'Image:') }}
			        <center>{{ Form::file('image') }}</center>
			    </p>
			    
			    <p>
				    {{ Form::label('color', 'Color:') }}
				    <select name="color">
				        @foreach($colors AS $color)
				            <option value="{{ $color->id }}">{{ ucfirst($color->name) }}</option>
				        @endforeach
				    </select>
				</p>

				<p>
				    {{ Form::label('species', 'Species:') }}
				    <select name="species">
				        @foreach($species AS $specie)
				            <option value="{{ $specie->name }}">{{ ucfirst($specie->name) }}</option>
				        @endforeach
				    </select>
				</p>
				
				<p>
				    {{ Form::label('type', 'Type:') }}
				    <select name="type">
				        <option value="skin">Skin</option>
				        <option value="horns">Horns</option>
				        <option value="horns_pointed">Horns (Pointed)</option>
				        <option value="eyes">Eyes</option>
				        <option value="lineart">Lineart</option>
				    </select>
				</p>

				<p>
					{{ Form::submit('Upload Base Image!', array('class' => 'btn btn-primary')) }}
				</p>
			{{ Form::close() }}
		</div>
	</div>
@stop