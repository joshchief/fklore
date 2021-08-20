@extends('themes.default.layout')

@section('header')

  <script src="/assets/js/create.js" type="text/javascript"></script>
  <meta name="_token" content="{{ csrf_token() }}"/> 
  
  <style>
    .race ul {
        display:none;   
    }
    .race:hover ul {
        display:block;   
        position:relative;
        right:-50px;
        top:-25px;
        list-style: none;
        width: 130px;
        text-align: left;
    }
  </style>
@stop
    
@section('content')
  <div style="background: url('/assets/img/creator_background.png'); width: 790px; height: 780px">
      {{ Form::open(array('url' => '/create/elemental')) }}
        <div class="row" style="padding: 10px; color: #ffffff;">
            <div class="col-md-8" style="text-align: left; margin-top: 130px; padding: 10px;">
                <img src="/assets/img/stage2_backdrop.png" style="position: absolute; top: -140px;" />
                @if(!isset($image))
                <img id="create-img" src="/assets/img/{{ strtolower($species->name) }}.png" style="position: relative; z-index: 100;" />
                @else
                <img id="create-img" src="{{ $image }}" style="position: relative; z-index: 100;" />
                @endif
                
                <div class="topmargin_s" style="position: relative; z-index: 100;">
                    <center>
                        <input id="species" type="hidden" name="species" value="{{ strtolower($species->name) }}" />
                        <button type="submit" class="btn btn-success">Align</button> 
                        <a href="/create" class="btn btn-primary">Back</a>
                    </center>
                </div>
            </div>
            
            <div class="col-md-4" style="margin-top: 20px;">
                <div style="padding: 20px;">
                    <h3 style="text-align: center; font-weight: bold;"><u>PROFILE</u></h3>
                    
                    <div class="topmargin_s">
                        NAME
                        <input name="name" type="text" value="{{ (isset($iName)) ? $iName : Input::old('name') }}" class="form-control" />
                        @if(Session::has('nameError'))
                            <div>
                                <span style="font-size: 11px; color: #e50000;">{{ Session::get('nameError') }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="topmargin_s">
                        BIRTHDAY<br />
                        <input type="text" value="{{ date("M d") }}" class="form-control" style="width: 60%; display: inline;" readonly />
                        
                        <input type="text" value="y1" class="form-control" style="width: 30%; display: inline; margin-left: 14px;" readonly />
                    </div>
                </div>
                
                <div style="margin-top: 10px; padding: 20px;">
                    <div style="text-align: center;">
                        <h3 style="font-weight: bold;"><u>BODY</u></h3>
                    </div>
                
                    <div class="topmargin_s">
                        SKIN
                        <select id="skin" name="skin" class="form-control">
                          @foreach($skins AS $skin)
                            <option value="{{ $skin->color->name }}" @if(isset($iSkin) && $iSkin == $skin->color->name) selected @elseif(Input::old('skin') && Input::old('skin') == $skin->color->name) selected @elseif(!isset($iSkin) && strtolower($skin->color->name) == 'red') selected @endif>{{ ucfirst($skin->color->name) }}</option>
                          @endforeach
                        </select>
                    </div>
                    
                    <div class="topmargin_s">
                        EYES
                        <select id="eyes" name="eyes" class="form-control">
                          @foreach($eyes AS $eye)
                            <option value="{{ $eye->color->name }}"  @if(isset($iEyes) && $iEyes == $eye->color->name) selected @elseif(Input::old('eyes') && Input::old('eyes') == $eye->color->name) selected @endif>{{ ucfirst($eye->color->name) }}</option>
                          @endforeach
                        </select>
                    </div>
                    
                    @if($horns)
                    <div class="topmargin_s">
                        <center><h3 style="font-weight: bold;"><u>HORNS</u></h3></center>
                        TYPE
                        <select id="horns" name="horns" class="form-control">
                          @if($species->horns)
                            <option value="normal" @if(isset($iHorns) && $iHorns == 'normal') selected @elseif(Input::old('horns') && Input::old('horns') == 'normal') selected @endif>Smooth</option>
                          @endif
                          
                          @if($species->horns_pointed)
                            <option value="pointed" @if(isset($iHorns) && $iHorns == 'pointed') selected @elseif(Input::old('horns') && Input::old('horns') == 'pointed') selected @endif>Rough</option>
                          @endif
                        </select>
                    </div>
                    
                    <div class="topmargin_s">
                        COLOR
                        <select id="horn_color" name="horn_color" class="form-control">
                          @foreach($horns AS $horn)
                            <option value="{{ $horn->color->name }}" @if(isset($iHorn_color) && $iHorn_color == $horn->color->name) selected @elseif(Input::old('horn_color') && Input::old('horn_color') == $horn->color->name) selected @endif>{{ ucfirst($horn->color->name) }}</option>
                          @endforeach
                        </select>
                    </div>
                    @endif
                </div>
                
                @if($species->promo)
                <div style="border: 1px solid #ffffff; margin-top: 10px; padding: 20px;">
                    <h3 style="text-align: center; font-weight: bold;">Promo Code</h3>
                    
                        <div class="topmargin_s">
                            <div class="topmargin_s">
                            CODE
                            <input name="promo" type="text" value="{{ (isset($iPromo)) ? $iPromo : Input::old('promo') }}" class="form-control" />
                            @if(Session::has('promoError'))
                                <div>
                                    <span style="font-size: 11px; color: #e50000;">{{ Session::get('promoError') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        {{ Form::close() }}
  </div>
@stop