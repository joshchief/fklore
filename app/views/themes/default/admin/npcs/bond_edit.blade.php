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
		<a href="/admin/npcs/bond-add/{{ $bond->npc_id }}" class="btn btn-success">New</a>
	</div>

	<div class="row">
		<div class="col-md-12" style="margin-top: 20px; text-align: center;">
			{{ Form::model($bond, array('url' => '/admin/npcs/bond-edit/'.$bond->id, 'method' => 'post', 'files' => true)) }}
			    <p>
			         <center><img src="/assets/images/npcs/images/{{ $bond->image }}?time()" /></center>
			    </p>
			    
				<p>
			        {{ Form::label('image', 'Image:') }}
			        <center>{{ Form::file('image') }}</center>
			    </p>
			    
				<p>
				    {{ Form::label('description', 'Text:') }}<br />
				    <textarea name="description" cols="80" rows="10">{{ $bond->description }}</textarea>
				</p>
				
				<p>
				    {{ Form::label('bond_type', 'Bond Type:') }}
				    <select name="bond_type">
				        <option value="like" @if($bond->bond_type == 'like') selected @endif>Like</option>
				        <option value="dislike" @if($bond->bond_type == 'dislike') selected @endif>Dislike</option>
				        <option value="level 1" @if($bond->bond_type == 'level 1') selected @endif>Level 1</option>
				        <option value="level 2" @if($bond->bond_type == 'level 2') selected @endif>Level 2</option>
				        <option value="level 3" @if($bond->bond_type == 'level 3') selected @endif>Level 3</option>
				        <option value="level 4" @if($bond->bond_type == 'level 4') selected @endif>Level 4</option>
				        <option value="reward" @if($bond->bond_type == 'reward') selected @endif>Reward</option>
				    </select>
				</p>

				<p>
					{{ Form::submit('Edit!', array('class' => 'btn btn-primary')) }}
				</p>
			{{ Form::close() }}
		</div>
	</div>
@stop