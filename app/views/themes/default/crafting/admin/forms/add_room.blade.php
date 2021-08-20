@extends('themes.default.layout')

@section('title')
    Add Room
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin">Admin Panel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.crafting') }}">Crafting</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Room</li>
    </ol>
</nav>
@include('themes.default.messages.includes.errors')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Add Room
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.crafting.postadd', ['object'=>'room']) }}">
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-4">
                            <label for="room_name">Room Name</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="room_name" id="room_name" class="form-control" />
                        </div>
                    </div>
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-4">
                            <a class="my-btn btn-danger my-btn-sm" href="{{ route('admin.crafting') }}">Cancel</a>
                        </div>
                        <div class="col-4">
                            &nbsp;
                        </div>
                        <div class="col-4" style="text-align: right;">
                            <input type="submit" name="add_room" class="my-btn btn-success my-btn-sm" value="Save" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection