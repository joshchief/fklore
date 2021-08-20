@extends('themes.default.layout')

@section('title')
    Crafting Recipes
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin">Admin Panel</a></li>
        <li class="breadcrumb-item active" aria-current="page">Crafting</li>
    </ol>
</nav>
@include('themes.default.messages.includes.errors')
<div class="row">
    <div class="col-md-12" style="text-align: right; padding-bottom: 10px;">
        <a class="my-btn btn-success white-font" href="{{ route('admin.crafting.addobject', ['object'=>'room']) }}">Add Room</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 10%;">ID</th>
                <th style="width: 50%;">Name</th>
                <th style="width: 5%;">Appliances</th>
                <th style="width: 5%;">Recipes</th>
                <th style="width: 30%;">Options</th>
            </tr>
            </thead>
            <tbody>
                @if(count($rooms) == 0)
                <tr>
                    <td colspan="5" style="text-align: center; vertical-align: middle;">There are no rooms.</td>
                </tr>
                @else
                    @foreach($rooms as $room)
                        <tr>
                            <td >{{ $room->id }}</td>
                            <td>{{ $room->name }}</td>
                            <td>{{ count($room->appliances()->get()) }}</td>
                            <td>{{ count($room->recipes()->get()) }}</td>
                            <td class="btn-group" style="width: 100%; vertical-align: middle; text-align: right;">
                                <a class="my-btn btn-info my-btn-sm" href="{{ route('admin.crafting.room', ['id'=>$room->id]) }}">View</a>
                                <a class="my-btn btn-warning my-btn-sm" href="#">Edit</a>
                                <form class="deleteform" method="post" action="{{ route('admin.crafting.delete', $room->id) }}">
                                    <input class="deletetype" type="hidden" name="type" value="room" />
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="submit" class="deletebutton my-btn btn-danger my-btn-sm" value="Delete" />
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.min.css">
@stop
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>
    <script src="{{ url('/') }}/assets/js/crafting.deleter.js?v={{ mt_rand() }}"></script>
@stop