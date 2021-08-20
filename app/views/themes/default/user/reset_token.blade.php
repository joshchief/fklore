@extends('themes.default.layout')

@section('title')
  Password Reset
@stop

@section('content')
	 @if(!Session::has('success'))
    <div style="margin-left: 100px;">
	{{ Form::open(array('url' => '/user/reset/'.$token, 'method' => 'post')) }}
	    <div style="width: 80%">
        	<h1>Password Reset</h1>
            <p>Please enter and confirm your password</p>
            <hr>

            <div class="align-center">
                <label for="username"><b>Username:</b></label> {{ $username }}

            </div>
            
            <div class="topmargin_l">
                <label for="password"><b>New Password:</b></label><br />
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter a new password.')) }}
            </div>
            
            <div class="topmargin_l">
                <label for="password"><b>Confirm Password:</b></label><br />
                {{ Form::password('passwordConfirm', array('class' => 'form-control', 'placeholder' => 'Verify Password.')) }}
            </div>
            
            <div class="topmargin_l">
                <center>{{ Form::submit('Continue', array('class' => 'btn btn-primary')) }}</center>
            </div>
        </div>
        
	@else
	<div class="row topmargin_l">
		<div class="col-xs-12">
			<div class="alert alert-success fade in align-center">
				{{ Session::get('success') }}
			</div>
		</div>
	</div>
	@endif
@stop