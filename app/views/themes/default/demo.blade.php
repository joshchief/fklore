@extends('themes.default.layout')

@section('header')

  <script src="/assets/js/demo.js" type="text/javascript"></script>
  <meta name="_token" content="{{ csrf_token() }}"/> 
@stop
    
@section('content')
  <div class="row" style="padding: 10px;">
    <div class="col-md-8 demo-image">
      <div id="demo-img"><img src="/assets/images/base/species_default.png" width="500px" height="500px" /></div>
    </div>

    <div class="col-md-4">
      <div class="demo-section">
        <span class="demo-heading">Base</span> Required.
      </div>

      <div class="topmargin_s">
        <select id="species" name="species" class="form-control">
          @foreach($species AS $specie)
            <option value="{{ $specie->name }}">{{ ucfirst($specie->name) }}</option>
          @endforeach
        </select>
      </div>
      
      <div id="hornSection" class="topmargin_s">
        <select id="horns" name="horns" class="form-control">
          @foreach($horns AS $horn)
            <option value="{{ $horn->color->name }}">{{ ucfirst($horn->color->name) }}</option>
            <option value="{{ $horn->color->name }}_pointed">{{ ucfirst($horn->color->name) }} (Rough)</option>
          @endforeach
        </select>
      </div>

      <div class="topmargin_s">
        <select id="skin" name="skin" class="form-control">
          @foreach($skins AS $skin)
            <option value="{{ $skin->color->name }}">{{ ucfirst($skin->color->name) }}</option>
          @endforeach
        </select>
      </div>

      <div class="topmargin_s">
        <select id="eyes" name="eyes" class="form-control">
          @foreach($eyes AS $eye)
            <option value="{{ $eye->color->name }}">{{ ucfirst($eye->color->name) }}</option>
          @endforeach
        </select>
      </div>

      <div class="demo-section topmargin_l">
        <span class="demo-heading">Clothing</span>
      </div>

      <div class="topmargin_s">
        <select id="head" name="head" class="form-control">
          <option value="">Head</option>
          @foreach($headArray AS $image => $name)
            <option value="{{ $image }}">{{ ucfirst($name) }}</option>
          @endforeach
        </select>
      </div>

      <div class="topmargin_s">
        <select id="accessory" name="accessory" class="form-control">
          <option value="">Accessory</option>
          @foreach($accessoryArray AS $image => $name)
            <option value="{{ $image }}">{{ ucfirst($name) }}</option>
          @endforeach
        </select>
      </div>

      <div class="topmargin_s">
        <select id="top" name="top" class="form-control">
          <option value="">Top</option>
          @foreach($topArray AS $image => $name)
            <option value="{{ $image }}">{{ ucfirst($name) }}</option>
          @endforeach
        </select>
      </div>

      <div class="topmargin_s">
        <select id="bottom" name="bottom" class="form-control">
          <option value="">Bottom</option>
          @foreach($bottomArray AS $image => $name)
            <option value="{{ $image }}">{{ ucfirst($name) }}</option>
          @endforeach
        </select>
      </div>
      
      <div class="demo-section topmargin_l">
        <span class="demo-heading">Background</span>
      </div>
      
      <div class="topmargin_s">
        <select id="background" name="background" class="form-control">
          <option value="">Background</option>
          @foreach($backgroundArray AS $image => $name)
            <option value="{{ $image }}">{{ ucfirst($name) }}</option>
          @endforeach
        </select>
      </div>

      <div class="topmargin_s align-center">
        <input id="pos-counter" type="hidden" name="posCounter" value="0" />
        <button id="save-img" class="btn btn-lg btn-primary">Save Image</button>
      </div>
    </div>
  </div>

  <div class="row topmargin_l" style="padding: 10px;">
    <div class="col-md-12">
        <div id="clothing-sort" class="row demo-equipped">
            
        </div>
    </div>
  </div>
@stop