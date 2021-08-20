@extends('themes.default.layout')

@section('title')
	Forums
@stop

@section('content')
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/" style="color: #53a7e0;">Home</a></li>
        <li class="breadcrumb-item"><a href="/forums" style="color: #53a7e0;">Forums</a></li>
        <li class="breadcrumb-item"><a href="/forums/view/{{ $reply->forum_id }}" style="color: #53a7e0;">{{ $reply->forum->name }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Reply</li>
      </ol>
    </nav>

    <div class="row align-center topmargin_l">
        <div class="col-md-12">
            <h1><span style="color: #355b7d;"><b>Edit Reply</b></span></h1>
        </div>
    </div>
    
    @if(Session::has('postErrors'))
    	@foreach(Session::get('postErrors') AS $error)
        	<div class="row">
        		<div class="col-md-12" style="text-align: center;">
        			 <span style="color: #ff0000;">Error! {{ $error }}</span>
        		</div>
        	</div>
        @endforeach
    @endif
    
    {{ Form::model($reply, array('url' => '/forums/edit-reply/'.$reply->id)) }}
    <div class="row topmargin_l">
        <div class="col-md-12">
            <div class="forum-bg">
                <div class="forum-inner">
                    <div class="row inner-padding">
                        <div class="col-md-12">
                            <b>Post Text:</b> 
                            <textarea class="form-control" name="reply" cols="80" rows="10">{{ $reply->reply }}</textarea>
                        </div>
                    </div>
                    
                    <div class="row inner-padding align-center">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" value="1">Edit!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@stop