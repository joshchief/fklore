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
  <div style="background: url('/assets/img/creator_background.png'); width: 790px; height: 830px">
        <div class="row" style="padding: 10px; color: #ffffff;">
            <div class="col-md-8" style="text-align: left; margin-top: 130px; padding: 10px;">
                <div class="topmargin_s" style="position: absolute; z-index: 100; left: 180px; top: -80px;">
                    <h3 style="text-align: center; font-weight: bold;">Are You Ready?</h3>
                </div>
                
                <img src="/assets/img/stage2_backdrop.png" style="position: absolute; top: -140px;" />
                <img id="create-img" src="{{ $customImg }}" style="position: relative; z-index: 100;" />
                
                <div class="topmargin_s" style="position: relative; z-index: 100;">
                    <center>
                        <input id="species" type="hidden" name="species" value="{{ strtolower($species) }}" />
                        {{ Form::open(array('url' => '/create/complete', 'style' => 'display: inline-block;')) }}
                        <button type="submit" class="btn btn-success">Awaken</button> 
                        
                        <input type="hidden" name="species" value="{{ $species }}" />
                            <input type="hidden" name="name" value="{{ $name }}" />
                            <input type="hidden" name="promo" value="{{ $promo }}" />
                            <input type="hidden" name="skin" value="{{ $skin }}" />
                            <input type="hidden" name="eyes" value="{{ $eyes }}" />
                            <input type="hidden" name="horns" value="{{ $horns }}" />
                            <input type="hidden" name="horn_color" value="{{ $horn_color }}" />
                            <input type="hidden" name="element" value="{{ $element }}" />
                        {{ Form::close() }}
                        
                        {{ Form::open(array('url' => '/create/elemental', 'style' => 'display: inline-block;')) }}
                        
                                <button type="submit" class="btn btn-primary">Back</button> 

                            <input type="hidden" name="species" value="{{ $species }}" />
                            <input type="hidden" name="name" value="{{ $name }}" />
                            <input type="hidden" name="promo" value="{{ $promo }}" />
                            <input type="hidden" name="skin" value="{{ $skin }}" />
                            <input type="hidden" name="eyes" value="{{ $eyes }}" />
                            <input type="hidden" name="horns" value="{{ $horns }}" />
                            <input type="hidden" name="horn_color" value="{{ $horn_color }}" />
                            <input type="hidden" name="element" value="{{ $element }}" />
                        {{ Form::close() }}
                    </center>
                </div>
            </div>
            
            <div class="col-md-4" style="margin-top: 20px;">
                <div style="padding: 20px;">
                    <h3 style="text-align: center; font-weight: bold;"><u></u>PROFILE</u></h3>
                    
                    <div class="topmargin_s">
                        NAME
                        <input name="name" type="text" value="{{ ucfirst($name) }}" class="form-control" readonly />
                    </div>
                    
                    <div class="topmargin_s">
                        BIRTHDAY<br />
                        <input type="text" value="{{ date("M d") }}" class="form-control" style="width: 60%; display: inline;" readonly />
                        
                        <input type="text" value="y1" class="form-control" style="width: 30%; display: inline; margin-left: 14px;" readonly />
                    </div>
                </div>
                
                <div style="margin-top: 10px; padding: 20px;">
                    <div style="text-align: center;">
                        <h3 style="font-weight: bold;"><u>COLORS</u></h3>
                    </div>
                
                    <div class="topmargin_s">
                        SKIN
                        <input name="skin" type="text" value="{{ ucfirst($skin) }}" class="form-control" readonly />
                    </div>
                    
                    <div class="topmargin_s">
                        EYES
                        <input name="eyes" type="text" value="{{ ucfirst($eyes) }}" class="form-control" readonly />
                    </div>
                    
                    @if($horns)
                    <div class="topmargin_s">
                        <center><h3 style="font-weight: bold;"><u></u>HORNS</u></h3></center>
                        TYPE
                        <input name="horns" type="text" value="{{ ucfirst($horns) }}" class="form-control" readonly />
                    </div>
                    
                    <div class="topmargin_s">
                        COLOR
                        <input name="horn_color" type="text" value="{{ ucfirst($horn_color) }}" class="form-control" readonly />
                    </div>
                    @endif
                </div>
                
                <div style="margin-top: 10px; padding: 20px;">
                    <h3 style="text-align: center; font-weight: bold;"><u></u>Elemental Alignment</u></h3>
                    
                    <div class="topmargin_s">
                        <center>
                            @if($element == '1')
                                <img src="/assets/images/elements/element_fire.png" style="width: 50px; height: 50px;" /> 
                                <p style="text-align: center; color: #63e2f5;">
                                     Fire is a favorite among hard-hitting physical fighters, or close range magic users. This versatile element will leave your foes with lasting burns and provide resistance to ice and specter attacks.
                                </p>
                            @elseif($element == '2')
                                <img src="/assets/images/elements/element_ice.png" /> 
                                <p style="text-align: center; color: #63e2f5;">
                                    Ice will freeze your opponents in their tracks! It is best used with strong, magic attacks at close range and do high damage to water, earth, and specter opponents.
                                </p>
                            @elseif($element == '3')
                                <img src="/assets/images/elements/element_water.png" /> 
                                <p style="text-align: center; color: #63e2f5;">
                                    While water attacks may not be as hard hitting for physical fighters, its capability with magic is endless! Perfect for both close and ranged magic attacks, especially against fire or earth opponents.
                                </p>
                            @elseif($element == '4')
                                <img src="/assets/images/elements/element_earth.png" /> 
                                <p style="text-align: center; color: #63e2f5;">
                                    Earth is a favorite among magic based races for its healing capabilities. But it can also be incredibly powerful for close-ranger physical attacks. Wind and light opponents are especially weak against earth attacks.
                                </p>
                            @elseif($element == '5')
                                <img src="/assets/images/elements/element_light.png" /> 
                                <p style="text-align: center; color: #63e2f5;">
                                    Light is a powerful magical element that can be used for both close and ranged attacks. Although it has weaknesses, when used properly a a Light-based fighter can be among some of the most powerful opponents, especially up aginst specter or ice foes.
                                </p>
                            @elseif($element == '6')
                                <img src="/assets/images/elements/element_specter.png" /> 
                                <p style="text-align: center; color: #63e2f5;">
                                    Specter based fighters harness moonlight#63e2f5 into powerful attacks for themselves and their teammates. It's favored among Lycans, and does massive damage to earth and other specter based foes.
                                </p>
                            @elseif($element == '7')
                                <img src="/assets/images/elements/element_wind.png" /> 
                                <p style="text-align: center; color: #63e2f5;">
                                  Wind based fighters rely on speed and range to pull off their more powerful attacks. Attacks from Wind elements can be made in rapid succession and greatly damage fire and water based opponents.
                                </p>
                            @endif
                        </center>
                    </div>
                </div>
            </div>
        </div>
  </div>
@stop