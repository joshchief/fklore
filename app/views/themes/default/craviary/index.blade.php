@extends('themes.default.layout')

@section('title')
Craviary
@stop

@section('content')
    <center><h1>Craviary</h1></center>
    <div class="row align-center topmargin_l">
        @foreach($craviary AS $specie)
        <div class="col-md-4">
            <div class="card">
                <img class="card-img-top" src="/assets/images/craviary/{{ $specie->image }}" alt="Card image" style="width:100%">
                <div class="card-body">
                  <h5 class="card-title"><b>{{ $specie->name }}</b></h5>
                  <p class="card-text">{{ $specie->description }}</p>
                </div>
            </div>
        </div><br><br>
        @endforeach
    </div>
@stop