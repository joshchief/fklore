@extends('themes.default.layout')

@section('header')

  <script src="/assets/js/demo.js" type="text/javascript"></script>
  <meta name="_token" content="{{ csrf_token() }}"/> 
  
  <style>
    .race ul {
        display:none;   
    }
    .race:hover ul {
        display:block;   
        position:relative;
        right:-50px;
        top:-80px;
        list-style: none;
        width: 130px;
        text-align: left;
    }
  </style>
@stop
    
@section('content')
  <div style="background: url('/assets/img/creator_background.png'); width: 790px; height: 750px">
        <div class="row" style="padding: 10px; color: #ffffff;">
            <div class="col-md-12" style="text-align: center; margin-top: 10px;">
                <h1>Select a Bloodline</h1>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-6" style="text-align: center; margin-top: 10px; padding: 10px;">
                <i><span id="blood-desc">“Known as creatures of the night, Nocturnes are rumored to derive power directly from the moon.”</span></i>
            </div>
            
            <div class="col-md-3"></div>
            <div class="col-md-9" style="text-align: center; margin-left: 130px; padding: 10px;">
                <img id="create-img" src="/assets/images/bloodlines/create/lycan_create.png" height="500px" />
                
                <div class="topmargin_s" >
                    <center>
                        <a id="next-link" href="/create/customize/lycan" class="btn btn-success">Read the Stars</a> 
                    </center>
                </div>
            </div>
        </div>
        
        <div style="color: #ffffff; text-align: center; position: absolute; top: 75px; left: 50px;">
            
            @foreach($race AS $item)
            
            <div class="race" style="margin-top: 15px; width: 80px; height: 80px;">
                <img src="/assets/images/bloodlines/icons/{{ strtolower($item->name) }}.png" />
                
                <ul>
                    <li style="border-bottom: 1px solid #ffffff;"><b>Folk</b></li>
                    @foreach($item->species AS $species)
                    <li><b><a class="species-create" data-blood="{{ $item->description }}" href="javascript:void(0);">{{ ucfirst($species->name) }}</a></b></li>
                    @endforeach
                </ul>
            </div>
            
            @endforeach

        </div>
  </div>
@stop