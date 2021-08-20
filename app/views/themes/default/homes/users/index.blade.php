@extends('themes.default.layout')

@section('title')
    Your Home
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Your Home</li>
    </ol>
</nav>
@include('themes.default.messages.includes.errors')
<div class="row topmargin_l">
    <div class="col-12">
        <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            Coming soon!</div>
        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a class="btn primary" href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
                <li role="presentation"><a class="btn primary" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
                <li role="presentation"><a class="btn primary" href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
                <li role="presentation"><a class="btn primary" href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">a</div>
                <div role="tabpanel" class="tab-pane" id="profile">b</div>
                <div role="tabpanel" class="tab-pane" id="messages">c</div>
                <div role="tabpanel" class="tab-pane" id="settings">d</div>
            </div>

        </div>
    </div>
</div>
@endsection