@extends('themes.default.layout')

@section('title')
    View Appliance
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin">Admin Panel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.crafting') }}">Crafting</a></li>
        <li class="breadcrumb-item active" aria-current="page">View Appliance: {{ $appliance->name }}</li>
    </ol>
</nav>
@include('themes.default.messages.includes.errors')
<div class="row">
    <div class="col-md-12" style="float: right; text-align: right; padding-bottom: 10px;">
        <div class="btn-group">
            <a class="my-btn btn-success white-font" href="{{ route('admin.crafting.addobject', ['object'=>'recipe']) }}">Add Recipe</a>
            <a class="my-btn btn-warning white-font" href="javascript:history.go(-1);">Go Back</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Output Item</th>
                <th>Input Item(s)</th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
            @if(count($recipes) == 0)
                <tr>
                    <td colspan="5" style="text-align: center; vertical-align: middle;">
                        There are no recipes registered for this room.
                    </td>
                </tr>
            @else
            @foreach($recipes as $recipe)
                <tr>
                    <td>{{ $recipe->id }}</td>
                    <td>{{ $recipe->name }}</td>
                    <td style="vertical-align: center;">
                        @if(count($recipe->result()->get()) == 0)
                            N/A
                        @else
                            <img style="height: 32px; width: 32px; vertical-align: center;" src="{{ url('/assets/images/items') }}/{{ $recipe->result()->get()[0]->image }}">
                        @endif
                    </td>
                    <td>
                        <?php $items = json_decode($recipe->input_items); ?>
                        <ul style="list-style:none; display:inline-block;">
                            @foreach($items as $item)
                                <li style="display:inline">
                                    <?php
                                    switch($item->type)
                                    {
                                        case 'currency_silver':
                                            $image = 'https://folkoflore.com/assets/img/silver_icon.png';
                                            $value = $item->amount;
                                            break;
                                        case 'currency_gold':
                                            $image = 'https://folkoflore.com/assets/img/gold_icon.png';
                                            $value = $item->amount;
                                            break;
                                        case 'item':
                                            $db_item = Items::where('id', $item->item_id)->first();
                                            $image = 'https://folkoflore.com/assets/images/items/'.$db_item->image;
                                            $value = $db_item->name;
                                            break;
                                    }
                                    ?>
                                    <img style="height:32px; width:32px;" src="{{ $image }}" />  {{ $value }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="text-align: center; vertical-align:middle;">
                        <div class="btn-group">
                            <a class="my-btn btn-warning my-btn-sm" href="#">Edit</a>
                            <form class="deleteform" method="post" action="{{ route('admin.crafting.delete', $recipe->id) }}">
                                <input class="deletetype" type="hidden" name="type" value="recipe" />
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="submit" class="deletebutton my-btn btn-danger my-btn-sm" value="Delete" />
                            </form>
                        </div>
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