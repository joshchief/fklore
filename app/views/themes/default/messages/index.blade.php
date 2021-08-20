@extends('themes.default.layout')

@section('title')
    Private Messages
@stop

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Private Messages</li>
    </ol>
</nav>
@include('themes.default.messages.includes.errors')
<div class="row topmargin_l">
    <div class="col-12">
        <div class="pms">
            <span class="box_head">Private Messages<span style="float:right; padding-right: 5px;"><strong><a href="{{route('messages.compose')}}" style="color: white;"><i class="fa fa-paper-plane"></i> Compose</a></strong></span></span>
        </div>
        <form method="post" action="{{ route('messages.delete') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="pms-body">
            <table style="width: 100%">
                <thead>
                <tr>
                    <th>Subject</th>
                    <th>Author</th>
                    <th>Sent Date</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @if(count($messages) == 0)
                <tr>
                    <td colspan="4" style="text-align: center; vertical-align: middle;">You have no messages.</td>
                </tr>
                @else
                @foreach($messages as $message)
                <tr>
                    <td><a href="{{ route('messages.view', [$message->id]) }}">{{ $message->subject }}</a></td>
                    
                    @if($message->from)
                    <td><a href="https://folkoflore.com/user/profile/{{$message->from}}">{{ $message->author->username }}</a></td>
                    @else
                    <td>Notification</td>
                    @endif
                    <td>{{ $message->created_at }}</td>
                    @if($message->notif != 1)
                    <td><input type="checkbox" name="delete[]" value="{{ $message->id }}"> Delete</td>
                    @endif
                </tr>
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-12">
                <div style="float: left;">
                    &nbsp;
                </div>
                <div style="float: right;">
                    <input disabled="disabled" type="submit" id="dodelete" name="deletemsgs" value="Delete Selected" class="btn btn-danger white-font">
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function(){
    let numSelected = 0;
    $('input[type=checkbox]').on('change', function(e){
        if($(this).is(':checked'))
        {
            numSelected++;
        }else{
            numSelected--;
        }
        if(numSelected <= 0)
        {
            numSelected = 0;
        }
        if(numSelected > 0)
        {
            $("#dodelete").attr("disabled", false);
        }else{
            $("#dodelete").attr("disabled", true);
        }
    })
});
</script>
@endsection