@extends('themes.default.layout')

@section('title')
	Forums
@stop

@section('content')
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/" style="color: #53a7e0;">Home</a></li>
        <li class="breadcrumb-item"><a href="/forums" style="color: #53a7e0;">Forums</a></li>
        <li class="breadcrumb-item"><a href="/forums/view/{{ $thread->forum->id }}" style="color: #53a7e0;">{{ $thread->forum->name }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $thread->title }}</li>
      </ol>
    </nav>

    <div class="row align-center topmargin_l">
        <div class="col-md-12">
            <h1><span style="color: #355b7d;"><b>{{ $thread->title }}</b></span></h1>
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
    
    <div class="row align-right topmargin_l">
        <div class="col-md-12">
            {{ $replies->links() }}
        </div>
    </div>
    
    @if($replies->getCurrentPage() == 1)
    <div class="row">
        <div class="col-md-12">
            <div class="forum-bg">
                <div class="forum-inner">
                    <div class="row inner-padding bottom-border">
                        <div class="col-md-3 align-center">
                            <b><a href="/user/profile/{{ $thread->user_id }}" style="color: #53a7e0;">{{ $thread->user->username }} (#{{ $thread->user_id }})</a></b><br />
                            
                            @if($thread->user->activeCharacter()->count() == 0)
                                <img class="user-avatar" src="http://via.placeholder.com/175x175" width="175" alt="Your icon">
                            @else
                                <a href="/character/profile/{{ $thread->user->active_character }}"><img class="user-avatar" src="/assets/images/characters/{{ $thread->user->active_character }}/image_cropped.png" width="100" style="border: 1px solid #000000;"></a>
                                <br />
                                {{ $thread->user->activeCharacter->name }} - Lvl {{ $thread->user->activeCharacter->level }}
                            @endif
                            
                            <hr />
                            
                            <b>Posts:</b> {{ number_format($thread->user->posts()->count() + $thread->user->threads()->count()) }}
                            
                            @if(Auth::user()->roles()['admin'] || Auth::user()->roles()['moderator'])
                            <h5><a href="/user/warn/{{ $thread->user->id }}" class="badge badge-warning">Warn User</a></h5>
                            
                            @endif
                        </div>

                        <div class="col-md-8" style="border-left: 2px solid #ffffff;">
                            {{ date("M d, Y @ h:ia", strtotime($thread->created_at)) }}
                            @if(Auth::user()->id == $thread->user_id || Auth::user()->roles()['admin'])
                            <span style="float: right;"><a href="/forums/edit-thread/{{ $thread->id }}" style="color: #53a7e0;"><b>Edit</b></a></span>
                            @endif
                            <hr />
                            {{ $thread->reply }}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @endif
    
    @foreach($replies AS $reply)
    <div class="row topmargin_l">
        <div class="col-md-12">
            <div class="forum-bg">
                <div class="forum-inner">
                    <div class="row inner-padding bottom-border">
                        <div class="col-md-3 align-center">
                            <b><a href="/user/profile/{{ $reply->user_id }}" style="color: #53a7e0;">{{ $reply->user->username }} (#{{ $reply->user_id }})</a></b><br />
                            
                            @if($reply->user->activeCharacter()->count() == 0)
                                <img class="user-avatar" src="http://via.placeholder.com/175x175" width="175" alt="Your icon">
                            @else
                                <a href="/character/profile/{{ $reply->user->active_character }}"><img class="user-avatar" src="/assets/images/characters/{{ $reply->user->active_character }}/image_cropped.png" width="100" style="border: 1px solid #000000;"></a>
                                <br />
                                {{ $reply->user->activeCharacter->name }} - Lvl {{ $reply->user->activeCharacter->level }}
                            @endif
                            
                            <hr />
                            
                            <b>Posts:</b> {{ number_format($reply->user->posts()->count() + $reply->user->threads()->count()) }}
                            
                            @if(Auth::user()->roles()['admin'] || Auth::user()->roles()['moderator'])
                            <h5><a href="/user/warn/{{ $reply->user->id }}" class="badge badge-warning">Warn User</a></h5>
                            
                            @endif
                        </div>

                        <div class="col-md-8" style="border-left: 2px solid #ffffff;">
                            {{ date("M d, Y @ h:ia", strtotime($reply->created_at)) }}
                            @if(Auth::user()->id == $reply->user_id || Auth::user()->roles()['admin'])
                            <span style="float: right;"><a href="/forums/edit-reply/{{ $reply->id }}" style="color: #53a7e0;"><b>Edit</b></a></span>
                            @endif
                            <hr />
                            {{ $reply->reply }}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
    <div class="row align-right">
        <div class="col-md-12">
            {{ $replies->links() }}
        </div>
    </div>
    
    @if(Auth::user()->roles()['admin'])
        <div class="row align-center topmargin_l">
            <div class="col-md-12">
                <b>Staff Actions:</b><br /><br />
                
                @if($thread->status != 2 && $thread->status != 1)
                    <a href="/forums/stick-thread/{{ $thread->id }}" onclick="return confirm('Are you sure you want to sticky this thread?');" class="btn btn-success">Sticky</a>
                @elseif($thread->status != 2 && $thread->status == 1)
                    <a href="/forums/stick-thread/{{ $thread->id }}" onclick="return confirm('Are you sure you want to unstick this thread?');" class="btn btn-success">Unstick</a>
                @endif
                
                @if($thread->status != 2)
                    <a href="/forums/lock-thread/{{ $thread->id }}" onclick="return confirm('Are you sure you want to lock this thread?');" class="btn btn-warning">Lock</a>
                @else
                    <a href="/forums/lock-thread/{{ $thread->id }}" onclick="return confirm('Are you sure you want to reopen this thread?');" class="btn btn-warning">Reopen</a>
                @endif
                
                <a href="/forums/delete-thread/{{ $thread->id }}" onclick="return confirm('Are you sure you want to delete this thread?');" class="btn btn-danger">Delete</a><br /><br />
                
                <b>Move Thread:</b><br /><br />
                {{ Form::open(array('url' => '/forums/move-thread/'.$thread->id)) }}
                <select name="category">
                    @foreach($categories AS $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <br /><br />
                <button onclick="return confirm('Are you sure you want to move this thread?');" name="submit" type="submit" class="btn btn-primary" value="1">Move!</button>
                {{ Form::close() }}
            </div>
        </div>
    @endif
    
    @if($thread->status != 2)
    {{ Form::open() }}
    <div class="row topmargin_l">
        <div class="col-md-12">
            <div class="forum-bg">
                <div class="forum-inner">
                    <div class="row inner-padding bottom-border">
                        <div class="col-md-12">
                            <b>Reply to Thread</b>
                        </div>
                    </div>
                    
                    <div class="row inner-padding">
                        <div class="col-md-12">
                            <b>Post Text:</b> 
                            <textarea class="form-control" name="reply" cols="80" rows="10"></textarea>
                        </div>
                    </div>
                    
                    <div class="row inner-padding align-center">
                        <div class="col-md-12">
                            <button name="submit" type="submit" class="btn btn-primary" value="1">Reply!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
    @else
    <div class="row topmargin_l">
        <div class="col-md-12">
            <div class="forum-bg">
                <div class="forum-inner">
                    <div class="row inner-padding bottom-border">
                        <div class="col-md-12 align-center">
                            <b>This thread has been closed.</b>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <br /><br />
@stop