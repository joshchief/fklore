@extends('themes.default.layout')

@section('title')
	Login
@stop

@section('content')
    <div style="margin-left: 100px;">
	{{ Form::open(array('url' => '/user/login')) }}
		
		<div style="width: 80%">
        	<h1>Login</h1>
            <p>Please enter your details to login.</p>
            <hr>

            <div>
                <label for="username"><b>Username</b></label><br />
                {{ Form::text('username', Input::old('username'), array('class' => 'form-control')) }}<br />
            </div>
            
            <div>
                <label for="password"><b>Password</b></label><br />
                {{ Form::password('password', array('class' => 'form-control')) }}<br />
            </div>
            
            <div>
                <center>{{ Form::submit('Login', array('class' => 'btn btn-primary')) }}</center>
            </div>
            
            <div class="topmargin_s">
                <center><a href="/user/reset" style="color: #0056c3;">Forgot Password?</a></center>
            </div>
        </div>
	{{ Form::close() }}
	</div>
@stop