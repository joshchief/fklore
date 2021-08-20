@extends('themes.default.layout')

@section('title')
    Add Appliance
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin">Admin Panel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.crafting') }}">Crafting</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Appliance</li>
    </ol>
</nav>
@include('themes.default.messages.includes.errors')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Add Appliance
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.crafting.postadd', ['object'=>'appliance']) }}">
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-4">
                            <label for="appliance_name">Appliance Name</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="appliance_name" id="appliance_name" class="form-control" />
                        </div>
                    </div>
                    @if(!isset($data['rooms']) || count($data['rooms']) == 0)
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-12">
                            You need to <a href="#">Add</a> some rooms for the appliance to go into.
                        </div>
                    </div>
                    @else
                        <div class="row" style="padding-bottom: 10px;">
                            <div class="col-4">
                                <label for="appliance_room">Appliance Room</label>
                            </div>
                            <div class="col-8">
                                <select name="appliance_room" id="appliance_room" class="form-control">
                                    <option selected="selected" value="-----">&#0187;&#0187;&#0187;&#0187; Select One &#0171;&#0171;&#0171;&#0171;</option>
                                    @foreach($data['rooms'] as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-4">
                            <a class="my-btn btn-danger my-btn-sm" href="{{ route('admin.crafting') }}">Cancel</a>
                        </div>
                        <div class="col-4">
                            &nbsp;
                        </div>
                        <div class="col-4" style="text-align: right;">
                            <input type="submit" name="add_appliance" class="my-btn btn-success my-btn-sm" value="Save" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection