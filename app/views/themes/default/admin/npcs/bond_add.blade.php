@extends('themes.default.layout')

@section('content')
	    <div class="align-center">
        <h1>Npcs</h1>
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
		<a href="/admin/npcs/bond-add/{{ $npc }}" class="btn btn-success">New</a>
	</div>

	<div class="row">
		<div class="col-md-12" style="margin-top: 20px; text-align: center;">
			{{ Form::open(array('url' => '/admin/npcs/bond-add/'.$npc, 'method' => 'post', 'files' => true)) }}
			    <p>
			        {{ Form::label('image', 'Image:') }}
			        <center>{{ Form::file('image') }}</center>
			    </p>

				<p>
				    {{ Form::label('description', 'Text:') }}<br />
				    <textarea name="description" cols="80" rows="10"></textarea>
				</p>
				
				<p>
				    {{ Form::label('bond_type', 'Bond Type:') }}
				    <select name="bond_type">
				        <option value="like" selected>Like</option>
				        <option value="dislike">Dislike</option>
				        <option value="level 1">Level 1</option>
				        <option value="level 2">Level 2</option>
				        <option value="level 3">Level 3</option>
				        <option value="level 4">Level 4</option>
				        <option value="reward">Reward</option>
				    </select>
				</p>

				<p>
					{{ Form::submit('Create!', array('class' => 'btn btn-primary')) }}
				</p>
			{{ Form::close() }}
		</div>
	</div>
@stop