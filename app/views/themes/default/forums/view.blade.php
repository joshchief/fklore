@extends('themes.default.layout')

@section('title')
	Forums
@stop

@section('content')
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/" style="color: #53a7e0;">Home</a></li>
        <li class="breadcrumb-item"><a href="/forums" style="color: #53a7e0;">Forums</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $forum->name }}</li>
      </ol>
    </nav>

    <div class="row align-center topmargin_l">
        <div class="col-md-12">
            <h1><span style="color: #355b7d;"><b>Forum: {{ $forum->name }}</span></b></h1>
        </div>
    </div>
    
    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="basic-addon2">
      <div class="input-group-append">
        <button class="btn btn-secondary" type="button">Go!</button>
      </div>
    </div>
    
    <div class="row align-right topmargin_l">
        <div class="col-md-12">
            @if(!$forum->staff || $forum->staff && Auth::user()->roles()['admin'])
                <a href="/forums/new-thread/{{ $forum->id }}" class="btn btn-success">New Thread</a>
            @endif
        </div>
    </div>
    
    <div class="row align-right topmargin_l">
        <div class="col-md-12">
            {{ $threads->links() }}
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="forum-bg">
                <div class="forum-inner">
                    @if($forum->threads()->count())
                        @foreach($threads AS $thread)
                            <div class="row inner-padding bottom-border ">
                                <div class="col-md-6">
                                    <a href="/forums/thread/{{ $thread->id }}" style="color: #53a7e0;"><b>{{ $thread->title }}</b></a><br />
                                    <b>By:</b> <a href="/user/profile/{{ $thread->user_id }}" style="color: #53a7e0;">{{ $thread->user->username }} (#{{ $thread->user_id }})</a>
                                </div>
                                
                                <div class="col-md-1">
                                    {{ number_format($thread->replies()->count()) }}
                                </div>
                                
                                <div class="col-md-1">
                                    @if(!$thread->status)
                                        Open
                                    @elseif($thread->status == 1)
                                        Stickied
                                    @else
                                        Closed
                                    @endif
                                </div>
                                
                                <div class="col-md-4">
                                    @if($thread->last_post)
                                        <b>By:</b>  <a href="/user/profile/{{ $thread->lastPost->user_id }}" style="color: #53a7e0;">{{ $thread->lastPost->user->username }} (#{{ $thread->lastPost->user_id }})</a><br />
                                        <b>Date:</b> {{ date("M d, Y @ h:ia", strtotime($thread->updated_at)) }}
                                    @else
                                        No Replies
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row inner-padding bottom-border">
                            <div class="col-md-12">
                                <center>There are no topics.</center>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row align-right topmargin_l">
        <div class="col-md-12">
            {{ $threads->links() }}
        </div>
    </div>
@stop