@extends('themes.default.layout')

@section('title')
	Warn User
@stop

@section('content')
    <div class="row align-center topmargin_l">
        <div class="col-md-12">
            <h2><span style="color: #355b7d;"><b>Warning User:</b> {{ $user->username }} (#{{ $user->id }})</span></h2>
        </div>
    </div>
    
    {{ Form::open() }}
    <div class="row topmargin_l">
        <div class="col-md-12">
            <div class="forum-bg">
                <div class="forum-inner">
                    <div class="row inner-padding">
                        <div class="col-md-12">
                            <b>Warning Text:</b> 
                            <textarea class="form-control" name="warning" cols="80" rows="10"></textarea>
                        </div>
                    </div>
                    
                    <div class="row inner-padding align-center">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" value="1">Send Warning!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@stop