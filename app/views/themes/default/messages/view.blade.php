@extends('themes.default.layout')

@section('title')
    Private Messages
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('messages') }}">Private Messages</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Message: {{ $message->subject }}</li>
        </ol>
    </nav>
    @include('themes.default.messages.includes.errors')
    <div class="row topmargin_l">
        <div class="col-12">
            <div class="pms">
                <span class="box_head">Private Messages<span style="float:right; padding-right: 5px;"><strong><a href="{{ route('messages') }}" style="color: white;"><i class="fa fa-arrow-left"></i> Back to Inbox</a></strong></span></span>
            </div>

            <div class="pms-body">
                <div class="row">
                    <div class="col-12">
                        @if($message->from)
                        <div style="float:left;">
                            <strong>Author</strong>: <a href="https://folkoflore.com/user/profile/{{$message->from}}">{{ $message->author->username }}</a>
                        </div>
                        @else
                        <div style="float:left;">
                            <strong>Author</strong>: Notification
                        </div>
                        @endif
                        <div style="float:right; padding-right: 10px;">
                            {{ date("M d, Y @ h:ia", strtotime($message->created_at)) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <strong>Message</strong>:
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">&nbsp;</div>
                    <div class="col-10">
                        <p>
                            {{ nl2br($message->message) }}
                        </p>
                    </div>
                </div>
                @if(count($message->attachments) > 0)
                <div class="row">
                    <div class="col-1">&nbsp;</div>
                    <div class="col-10">
                        <ol style="list-style: none;">
                            @foreach($message->attachments as $attachment)
                            <?php
                                switch($attachment->type)
                                {
                                    case 'currency_silver':
                                        $image = 'https://folkoflore.com/assets/img/silver_icon.png';
                                        $value = $attachment->quantity;
                                        break;
                                    case 'currency_gold':
                                        $image = 'https://folkoflore.com/assets/img/gold_icon.png';
                                        $value = $attachment->quantity;
                                        break;
                                    case 'item':
                                        $item = Items::where('id', $attachment->object_id)->first();
                                        $image = 'https://folkoflore.com/assets/images/items/'.$item->image;
                                        $value = $item->name;
                                        break;
                                }
                            ?>
                            <li @if($attachment->detached == 1)style="text-decoration: line-through;" data-toggle="tooltip" data-placement="left" title="This item has been detached already!"@endif><a href="{{ route('messages.detach', ['id'=>$attachment->id]) }}"><img style="height:40px; width:40px;" src="{{ $image }}" alt="attachment_{{$attachment->id}}" /> <kbd>{{ $value }}</kbd></a></li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                @endif
            </div>
            @if($message->notif != 1)
            <div class="row" style="padding-top: 10px;">
                <div class="col-6">&nbsp;</div>
                <div class="col-4 btn-group">
                    <a class="btn primary rounded white-font" id="reply">Reply</a>&nbsp;
                    <form method="post" action="{{ route('messages.delete') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" readonly name="delete" value="{{ $message->id }}" />
                        <input type="submit" class="btn btn-danger white-font rounded" value="Delete" />
                    </form>
                </div>
            </div>
            @endif
            <div class="row">&nbsp;</div>
            <div id="reply_box" style="display: none;">
                <form method="post" action="{{ route('messages.reply') }}">
                <div class="row">
                    <div class="col-12">
                        <div class="pms">
                            <span class="box_head">Reply</span>
                        </div>

                        <div class="pms-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="msg_id" value="{{ $message->id }}" />
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-1">
                                            <label for="message_message" style="font-weight: bold;">Message</label>
                                        </div>
                                        <div class="col-11">
                                            <textarea rows="10" id="message_message" name="message" class="form-control col-11"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 10px;">
                    <div class="col-8">&nbsp;</div>
                    <div class="col-2">
                        <input type="submit" class="btn primary rounded white-font" value="Send" />
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
$(document).ready(function(){
    $('#reply').click(function(){
        $('#reply_box').fadeIn();
    });
});
</script>
@endsection
