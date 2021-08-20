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
  <div style="background: url('/assets/img/creator_background.png'); width: 790px; height: 750px">
        <div class="row" style="padding: 10px; color: #ffffff;">
            <div class="col-md-7" style="text-align: left; margin-top: 50px; padding: 10px;">
                
                <div style="text-align: center; position: relative; z-index: 100;">
                    <h3 style="font-weight: bold;">Elemental Alignment</h3>
                </div>
                    
                <img id="create-img" src="{{ $customImg }}" style="position: relative; z-index: 100; padding: 20px;" />
            </div>
            
            <div class="col-md-4" style="margin-top: 50px; margin-left: 40px; ">
                <div class="row">
                    <div class="col-md-6" style="padding: 10px; text-align: center;">
                       <img id="fire" data-id="1" src="/assets/images/elements/element_fire.png" /> 
                    </div>
                    
                    <div class="col-md-6" style="padding: 10px; text-align: center;">
                       <img id="ice" data-id="2" src="/assets/images/elements/element_ice.png" /> 
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6" style="padding: 10px; text-align: center;">
                       <img id="water" data-id="3" src="/assets/images/elements/element_water.png" /> 
                    </div>
                    
                    <div class="col-md-6" style="padding: 10px; text-align: center;">
                       <img id="earth" data-id="4" src="/assets/images/elements/element_earth.png" /> 
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6" style="padding: 10px; text-align: center;">
                       <img id="light" data-id="5" src="/assets/images/elements/element_light.png" /> 
                    </div>
                    
                    <div class="col-md-6" style="padding: 10px; text-align: center;">
                       <img id="specter" data-id="6" src="/assets/images/elements/element_specter.png" />
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6" style="padding: 10px; text-align: center;">
                       <img id="wind" data-id="7" src="/assets/images/elements/element_wind.png" /> 
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12" style="margin-top: 10px; padding: 20px; background-color: #1c2767;">
                        <p id="element-stats" style="text-align: center; color: #63e2f5;">
                            @if(Input::get('element'))
                                @if(Input::get('element') == '1')
                                        Fire is a favorite among hard-hitting physical fighters, or close range magic users. This versatile element will leave your foes with lasting burns and provide resistance to ice and specter attacks.
                                @elseif(Input::get('element') == '2')
                                        Ice will freeze your opponents in their tracks! It is best used with strong, magic attacks at close range and do high damage to water, earth, and specter opponents.
                                @elseif(Input::get('element') == '3')
                                        While water attacks may not be as hard hitting for physical fighters, its capability with magic is endless! Perfect for both close and ranged magic attacks, especially against fire or earth opponents.
                                @elseif(Input::get('element') == '4')
                                        Earth is a favorite among magic based races for its healing capabilities. But it can also be incredibly powerful for close-ranger physical attacks. Wind and light opponents are especially weak against earth attacks.
                                @elseif(Input::get('element') == '5')
                                        Light is a powerful magical element that can be used for both close and ranged attacks. Although it has weaknesses, when used properly a a Light-based fighter can be among some of the most powerful opponents, especially up aginst specter or ice foes.
                                @elseif(Input::get('element') == '6')
                                       Specter based fighters harness moonlight into powerful attacks for themselves and their teammates. It's favored among Lycans, and does massive damage to earth and other specter based foes.
                                @elseif(Input::get('element') == '7')
                                        Wind based fighters rely on speed and range to pull off their more powerful attacks. Attacks from Wind elements can be made in rapid succession and greatly damage fire and water based opponents.
                                @endif
                            @else
                                 Choose the element that represents you.
                            @endif
                        </p>
                        
                        <p>
                           Your elemental alignment cannot be changed later, so consider each element carefully!
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="topmargin_s" style="position: relative; z-index: 100; bottom: 100px; left: -160px;">
                <center>
                {{ Form::open(array('url' => '/create/confirm', 'style' => 'display: inline-block;')) }}

                    <button type="submit" class="btn btn-success">Meditate</button> 
                <input type="hidden" name="species" value="{{ $species }}" />
                <input type="hidden" name="name" value="{{ $name }}" />
                <input type="hidden" name="promo" value="{{ $promo }}" />
                <input type="hidden" name="skin" value="{{ $skin }}" />
                <input type="hidden" name="eyes" value="{{ $eyes }}" />
                <input type="hidden" name="horns" value="{{ $horns }}" />
                <input type="hidden" name="horn_color" value="{{ $horn_color }}" />
                @if(Input::get('element'))
                    <input id="elementval" type="hidden" name="element" value="{{ Input::get('element') }}" />
                @else
                    <input id="elementval" type="hidden" name="element" value="1" />
                @endif
                
                {{ Form::close() }}
                
                {{ Form::open(array('url' => '/create/customize/'.$species, 'style' => 'display: inline-block;')) }}
                        
                                <button type="submit" class="btn btn-primary">Back</button> 

                            <input type="hidden" name="species" value="{{ $species }}" />
                            <input type="hidden" name="name" value="{{ $name }}" />
                            <input type="hidden" name="promo" value="{{ $promo }}" />
                            <input type="hidden" name="skin" value="{{ $skin }}" />
                            <input type="hidden" name="eyes" value="{{ $eyes }}" />
                            <input type="hidden" name="horns" value="{{ $horns }}" />
                            <input type="hidden" name="horn_color" value="{{ $horn_color }}" />
                            
                        {{ Form::close() }}
                        </center>
        </div>
  </div>
@stop