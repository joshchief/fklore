@extends('themes.default.layout')

@section('title')
	Forums
@stop

@section('content')
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/" style="color: #53a7e0;">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Forums</li>
      </ol>
    </nav>

    <div class="row align-center topmargin_l">
        <div class="col-md-12">
            <h1><span style="color: #355b7d;"><b>Forums</span></b></h1>
        </div>
    </div>
    
    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="basic-addon2">
      <div class="input-group-append">
        <button class="btn btn-secondary" type="button">Go!</button>
      </div>
    </div>
    
    <div class="row topmargin_l">
        <div class="col-md-12">
            <div class="forum-bg">
                <div class="forum-inner">
                    <div class="row inner-padding bottom-border">
                    <?php $i = 1; ?>
                    @foreach($categories AS $forum)
                        <div class="col-md-2 inner-padding">
                            <a href="/forums/view/{{ $forum->id }}"><img src="/assets/images/forums/{{ $forum->image }}" /></a>
                        </div>
                        
                        <div class="col-md-4 inner-padding">
                            <a href="/forums/view/{{ $forum->id }}" style="color: #000000"><b>{{ $forum->name }}</b></a><br />
                            {{ $forum->description }}<br /><br />
                            
                            <b>Posts:</b> {{ number_format($forum->replies()->count() + $forum->threads()->count()) }}<br />
                            <b>Last Post:</b> @if($forum->last_post == 0) No Posts @else <a href="/forums/thread/{{ $forum->last_post }}" style="color: #53a7e0;">{{ $forum->lastPost->title }}</a>  @endif
                        </div>
                        
                        @if($i % 2 == 0)
                            </div>
                            <div class="row inner-padding bottom-border">
                        @endif
                        
                        <?php $i++; ?>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop