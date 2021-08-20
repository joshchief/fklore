@extends('themes.default.layout')

@section('title')
    Private Messages
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('messages') }}">Private Messages</a></li>
        <li class="breadcrumb-item active" aria-current="page">Compose Message</li>
    </ol>
</nav>
@include('themes.default.messages.includes.errors')
<div class="row topmargin_l">
    <div class="col-12">
        <div class="pms">
            <span class="box_head">Compose Message<span style="float:right; padding-right: 5px;"><strong><a href="{{ route('messages') }}" style="color: white;"><i class="fa fa-arrow-left"></i> Back to Inbox</a></strong></span></span>
        </div>

        <div class="pms-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-1">
                            <label for="message_to" style="font-weight: bold;">Recipient</label>
                        </div>
                        <div class="col-11">
                            <input type="text" id="message_to" name="to" class="form-control col-4"@if(isset($append_data['to'])) value="{{ $append_data['to'] }}"@endif />
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="row">
                        <div class="col-1">
                            <label for="message_subject" style="font-weight: bold;">Subject</label>
                        </div>
                        <div class="col-11">
                            <input type="text" id="message_subject" name="subject" class="form-control col-4" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">&nbsp;</div>
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
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-1">
                            <label for="attach_silver"><img src="https://folkoflore.com/assets/img/silver_icon.png" alt="Silver Shils" /></label>
                        </div>
                        <div class="col-7">
                            <input type="text" class="form-control col-2" id="attach_silver" name="silver_shils" />
                        </div>
                        <div class="col-4">
                            <div class="attach_box" data-id="1" data-toggle="tooltip" data-placement="top" title="Attach an Item"><a><i class="attacher fa fa-1x fa-link"></i></a></div>
                            <div class="attach_box" data-id="2" data-toggle="tooltip" data-placement="top" title="Attach an Item"><a><i class="attacher fa fa-1x fa-link"></i></a></div>
                            <div class="attach_box" data-id="3" data-toggle="tooltip" data-placement="top" title="Attach an Item"><a><i class="attacher fa fa-1x fa-link"></i></a></div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <label for="attach_gold"><img src="https://folkoflore.com/assets/img/gold_icon.png" alt="Silver Shils" /></label>
                        </div>
                        <div class="col-7">
                            <input type="text" class="form-control col-2" id="attach_gold" name="gold_shils" />
                        </div>
                        <div class="col-4" style="padding-top: 5px;">
                            <div class="attach_box" data-id="4" data-toggle="tooltip" data-placement="top" title="Attach an Item"><a><i class="attacher fa fa-1x fa-link"></i></a></div>
                            <div class="attach_box" data-id="5" data-toggle="tooltip" data-placement="top" title="Attach an Item"><a><i class="attacher fa fa-1x fa-link"></i></a></div>
                            <div class="attach_box" data-id="6" data-toggle="tooltip" data-placement="top" title="Attach an Item"><a><i class="attacher fa fa-1x fa-link"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-12">
                <div style="float: left;">
                    <a class="btn primary white-font" id="preview">Preview</a>
                </div>
                <div style="float: right;">
                    <a class="btn primary white-font" id="send">Send</a>
                    <a class="btn btn-danger white-font" href="{{ route('messages') }}">Cancel</a>
                </div>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <div id="preview_box" style="display:none;"></div>
    </div>
</div>
<div class="modal fade" id="attachModal" tabindex="-1" role="dialog" aria-labelledby="attachModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attachModalLabel">Attach an Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 ">
                        &nbsp;<div class="row inv-view">&nbsp;</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.min.css">
@stop
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>
<script src="{{ url('/') }}/assets/js/mail.compose.js?v={{ mt_rand() }}"></script>
@stop