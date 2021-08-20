@extends('themes.default.layout')

@section('title')
	Register
@stop

@section('content')
	<div style="margin-left: 100px;">
	@if(!Cookie::get('access'))
	{{ Form::open(array('url' => '/user/register')) }}
	
	    @if(Session::has('success'))
                <div class="row col-xs-offset-4 col-xs-7 topmargin_l">
				    <div class="col-xs-12 alert alert-success">
                      <div class="alert-head">Success!</div> {{ Session::get('success') }}
                    </div>
                </div>

                {{ Session::forget('success') }}
              @endif
	    
		
		
		<div style="width: 80%">
        	<h1>Registration</h1>
            <p><h3>Please read our <a href="http://folkoflore.com/tos">Terms of Service</a> before registering to play!</h3></p>
            <hr>
            
            <div>
                <label for="birthday"><b>Birthdate (You must be 16 or older to play!)</b></label><br />
                <b>Month</b> {{ Form::selectRange('month', 1, 12, '', array('class' => 'form-control', 'style' => 'width: 25%; display: inline; margin-right: 12px;')) }} 
                <b>Day</b> {{ Form::selectRange('day', 1, 31, '', array('class' => 'form-control', 'style' => 'width: 25%; display: inline; margin-right: 12px;')) }} 
                <b>Year</b> {{ Form::selectRange('year', 1900, 2015, '', array('class' => 'form-control', 'style' => 'width: 25%; display: inline;')) }}<br /><br />
            </div>
            
            <div>
                <label for="email"><b>Email (for verification)</b></label><br />
                {{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}<br />
            </div>
            
            <div>
                <label for="referrer"><b>Referrer ID (optional)</b></label><br />
                {{ Form::text('referrer', Input::old('referrer'), array('class' => 'form-control')) }}<br />
            </div>
            
            <div>
                <label for="beta"><b>Beta Code </b></label><br />
                {{ Form::text('beta', Input::old('beta'), array('class' => 'form-control')) }}<br />
            </div>
            
            <div>
                <label for="username"><b>Username </b></label><br />
                {{ Form::text('username', Input::old('username'), array('class' => 'form-control')) }}<br />
            </div>
            
            <div>
                <label for="password"><b>Password (minmum: 15 characters)</b></label><br />
                {{ Form::password('password', array('class' => 'form-control', 'pattern' => '.{15,60}')) }}<br />
            </div>
            
            <div>
                <label for="passwordConfirm"><b>Confirm Password</b></label><br />
                {{ Form::password('passwordConfirm', array('class' => 'form-control', 'pattern' => '.{15,60}')) }}<br />
            </div>
            
            <div>
                <center>{{ Form::submit('Register', array('class' => 'btn btn-primary')) }}</center>
            </div>
        </div>
		
	{{ Form::close() }}
	@else
		<div class="row topmargin_l">
			<div class="col-xs-12">
				<div class="alert alert-danger align-center">
					You are under 16 and cannot submit an application!
				</div>
			</div>
		</div>
	@endif
	</div>
@stop