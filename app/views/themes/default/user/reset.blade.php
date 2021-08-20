@extends('themes.default.layout')

@section('title')
  Password Reset
@stop

@section('content')
    @if(!Session::has('success'))
    <div style="margin-left: 100px;">
	{{ Form::open(array('url' => '/user/reset', 'method' => 'post')) }}
		<div style="width: 80%">
        	<h1>Password Reset</h1>
            <p>Please enter the Required Information</p>
            <hr>

            <div>
                <label for="username"><b>Username</b></label><br />
                {{ Form::text('userReset', Input::old('userReset'), array('class' => 'form-control', 'placeholder' => 'Username of account.', 'maxlength' => '12')) }}
            </div>
            
            <div class="topmargin_l">
                <center>{{ Form::submit('Continue', array('class' => 'btn btn-primary')) }}</center>
            </div>
        </div>
	{{ Form::close() }}
	</div>
	@else
	<div style="margin-left: 100px;">
    	<div class="row topmargin_l">
    		<div class="col-xs-12">
    			<div class="alert alert-success fade in align-center">
    				{{ Session::get('success') }}
    			</div>
    		</div>
    	</div>
    </div>
	@endif
@stop