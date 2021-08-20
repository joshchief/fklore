@extends('themes.default.layout')

@section('title')
    View Room
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin">Admin Panel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.crafting') }}">Crafting</a></li>
        <li class="breadcrumb-item active" aria-current="page">View Room: {{ $room->name }}</li>
    </ol>
</nav>
@include('themes.default.messages.includes.errors')
<div class="row">
    <div class="col-md-12" style="text-align: right; padding-bottom: 10px;">
        <a class="my-btn btn-success white-font" href="{{ route('admin.crafting.addobject', ['object'=>'appliance']) }}">Add Appliance</a>
        <a class="my-btn btn-success white-font" href="{{ route('admin.crafting.addobject', ['object'=>'recipe']) }}">Add Recipe</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist" style="padding-bottom:10px;">
            <li role="presentation" class="active"><a class="btn btn-primary" href="#appliances" aria-controls="appliance" role="tab" data-toggle="tab">Appliances</a></li>
            <li role="presentation"><a class="btn btn-primary" href="#recipes" aria-controls="recipes" role="tab" data-toggle="tab">Recipes</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="appliances">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 50%;">Name</th>
                        <th style="width: 10%;">Recipes</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($appliances) == 0)
                        <tr>
                            <td colspan="4" style="text-align: center; vertical-align: middle;">
                                There are no appliances in this room.
                            </td>
                        </tr>
                    @else
                        @foreach($appliances as $appliance)
                            <tr>
                                <td>{{ $appliance->id }}</td>
                                <td>{{ $appliance->name }}</td>
                                <td>{{ count($appliance->recipes()->get()) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="my-btn btn-info my-btn-sm" href="{{ route('admin.crafting.appliance', ['id'=>$appliance->id]) }}">View</a>
                                        <a class="my-btn btn-warning my-btn-sm" href="#">Edit</a>
                                        <form class="deleteform" method="post" action="{{ route('admin.crafting.delete', $appliance->id) }}">
                                            <input class="deletetype" type="hidden" name="type" value="appliance" />
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
            <div role="tabpanel" class="tab-pane" id="recipes">
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
                    @if(count($room->recipes()->get()) == 0)
                        <tr>
                            <td colspan="5" style="text-align: center; vertical-align: middle;">
                                There are no recipes registered for this room.
                            </td>
                        </tr>
                    @else
                        @foreach($room->recipes()->get() as $recipe)
                            <tr>
                                <td>{{ $recipe->id }}</td>
                                <td>{{ $recipe->name }}</td>
                                <td>
                                    @if(count($recipe->result()->get()) == 0)
                                    N/A
                                    @else
                                    <img src="{{ url('/assets/images/items') }}/{{ $recipe->result()->get()[0]->image }}">
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
                                <td>
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