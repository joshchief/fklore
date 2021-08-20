@extends('themes.default.layout')

@section('title')
    Add Recipe
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin">Admin Panel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.crafting') }}">Crafting</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Recipe</li>
    </ol>
</nav>
@include('themes.default.messages.includes.errors')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Add Recipe
            </div>
            <div class="card-body">
                <div class="row" style="padding-bottom: 10px">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Notice</strong>: If you add the recipe to a room, don't select an appliance. Likewise for selecting an appliance, don't select a room!
                        </div>
                    </div>
                </div>
                <form method="post" action="{{ route('admin.crafting.postadd', ['object'=>'room']) }}">
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-4">
                            <label for="recipe_name">Recipe Name</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="recipe_name" id="recipe_name" class="form-control" />
                        </div>
                    </div>
                    @if(isset($data['rooms']) && count($data['rooms']) == 0)
                        <div class="row" style="padding-bottom: 10px;">
                            <div class="col-12">
                                There are no rooms. Maybe you should <a href="{{ route('admin.crafting.addobject', ['object'=>'room']) }}">add</a> some?
                            </div>
                        </div>
                    @else
                        <div class="row" style="padding-bottom: 10px;">
                            <div class="col-4">
                                <label for="recipe_room">Recipe Room</label>
                            </div>
                            <div class="col-8">
                                <select name="recipe_room" id="recipe_room" class="form-control">
                                    <option selected="selected" value="-----">&#0187;&#0187;&#0187;&#0187; Select One &#0171;&#0171;&#0171;&#0171;</option>
                                    @foreach($data['rooms'] as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if(isset($data['appliances']) && count($data['appliances']) == 0)
                        <div class="row" style="padding-bottom: 10px;">
                            <div class="col-12">
                                There are no appliances. Maybe you should <a href="{{ route('admin.crafting.addobject', ['object'=>'appliance']) }}">add</a> some?
                            </div>
                        </div>
                    @else
                        <div class="row" style="padding-bottom: 10px;">
                            <div class="col-4">
                                <label for="recipe_room">Recipe Appliance</label>
                            </div>
                            <div class="col-8">
                                <select name="recipe_room" id="recipe_room" class="form-control">
                                    <option selected="selected" value="-----">&#0187;&#0187;&#0187;&#0187; Select One &#0171;&#0171;&#0171;&#0171;</option>
                                    @foreach($data['appliances'] as $appliance)
                                        <option value="{{ $appliance->id }}">{{ $appliance->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-12" style="text-align: center;">
                            <strong>Input Items</strong>:<br />
                            <a class="my-btn btn-success my-btn-sm" href="#">Add Item</a>
                            <a class="my-btn btn-success my-btn-sm" href="#">Add Currency</a>
                        </div>
                    </div>
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-6" style="text-align: center; vertical-align: top;">
                            <strong style="font-size:12px; padding-bottom:5px;" class="badge badge-info">Output Item</strong><br />
                            <img src="#" alt="selected_output_item" id="selected_output_item" style="display: none; height: 50px; width: auto; padding-top: 5px; padding-bottom: 5px;" />
                            <i id="placeholder_output" class="fa fa-3x fa-question" style="padding-bottom: 5px; padding-top: 5px;"></i>
                            <select name="recipe_output" id="recipe_output" class="form-control"></select>
                        </div>
                        <div class="col-6" style="text-align: center; vertical-align: top;">
                            <div class="row" style="padding-bottom: 12px;">
                                <div class="col-12">
                                    <strong style="font-size:12px; padding-bottom:5px;" class="badge badge-info">Input Item(s)</strong><br />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <img src="https://folkoflore.com/assets/images/items/adobe.png" alt="itm" /><br />
                                    <small>x1</small>
                                </div>
                                <div class="col-2">
                                    <img src="https://folkoflore.com/assets/images/items/mahoganywood.png" alt="itm" /><br />
                                    <small>x1</small>
                                </div>
                                <div class="col-2">
                                    <img src="https://folkoflore.com/assets/img/silver_icon.png" alt="silver_shils" /><br />
                                    <small>x2000</small>
                                </div>
                            </div>
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
@section('header')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function(){
    let mloc = location.protocol + '//' + location.hostname + "/admin/crafting/itemList";
    $('#recipe_output').select2({
        ajax: {
            url: mloc,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results:  $.map(data.results, function (item) {
                        return {
                            text: item.name,
                            id: item.id,
                            img: item.image
                        }
                    })
                };
            },
            cache: true
        }
    });
    $('#recipe_output').on('select2:select', function (e) {
        let imgloc = location.protocol + '//' + location.hostname + '/assets/images/items/'+e.params.data.img;
        $('#placeholder_output').fadeOut(1000, function(){
            $('#selected_output_item').attr('src', imgloc);
            $('#selected_output_item').fadeIn();
        });
        // Do something
    });
});
</script>
@stop

