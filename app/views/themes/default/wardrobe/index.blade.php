@extends('themes.default.layout')

@section('header')

  <script src="/assets/js/demo.js" type="text/javascript"></script>
  <meta name="_token" content="{{ csrf_token() }}"/> 
@stop
    
@section('content')
  <div class="row" style="padding: 10px;">
    <div class="col-md-8 align-center">
      <h1>{{ $character->name }}</h1>
    </div>
      
    <div class="col-md-8">
        <div class="demo-image">
            <div id="demo-img"><img src="/assets/images/characters/{{ $character->id }}/image.png" width="500px" height="500px" /></div>
        </div>
      
        <div class="row topmargin_s">
            <div class="col-12 align-center">
                <a href="" class="btn primary">Apparel</a>&nbsp;&nbsp;

                <a href="" class="btn primary">Skin</a>
            </div>
        </div>
        
        <div class="row topmargin_l" style="padding: 10px;">
            <div class="offset-md-1 col-md-10 offset-md-1">
                <div id="clothing-sort" class="row demo-equipped">
                    
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <table class="table table-striped table-bordered">
              <tbody>
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
                
                <tr>
                  <td><i>Add an apparel</i></td>
                </tr>
              </tbody>
            </table>
        </div>

      <div class="topmargin_l align-center">
        <input id="pos-counter" type="hidden" name="posCounter" value="0" />
        <button id="save-img" class="btn btn-lg btn-primary">Save Image</button>
      </div>
    </div>
  </div>
@stop