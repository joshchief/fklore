@extends('themes.default.layout')

@section('content')

<div class="row align-center topmargin_l">
    <div class="col-md-12">
        <h1><span style="color: #5f5f5f;"><b>Latest News</span></b></h1>
    </div>
</div>

<div class="row align-right topmargin_l">
    <div class="col-md-12">
        {{ $news->links() }}
    </div>
</div>

@foreach($news as $post)
<div class="row topmargin_l">
    <div class="col-12">
        <div class="news">
            <span class="box_head">{{ date("M d, Y - H:i:s", strtotime($post->created_at)) }} LT</span>
        </div>
        
        <div class="news-body">
            <p style="text-align: center; color: #2c4657; font-size: 16px;"><strong>{{ $post->title }}</strong></p>
            <div class="topmargin_l">{{ str_limit($post->reply, $limit = 500, $end = '...') }}</div>
            
            <div class="topmargin_l">
                <a href="/forums/thread/{{ $post->id }}" class="btn danger">SEE FULL STORY</a>
                <span style="margin-left: 15px; color: #929292"><i>{{ number_format($post->replies()->count()) }} Comments</i></span>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="row align-right topmargin_l">
    <div class="col-md-12">
        {{ $news->links() }}
    </div>
</div>

@stop