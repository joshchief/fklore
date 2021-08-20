@extends('themes.default.layout')

@section('header')

  <meta name="_token" content="{{ csrf_token() }}"/> 

@stop
    
@section('content')
    <div class="row align-center">
        <div class="col-md-12">
            <h1><span style="color: #355b7d;"><b>{{ $shop->name }}</span></b></h1>
        </div>
        
        <div class="col-md-12">
            <img src="/assets/images/shops/{{ $shop->image }}" />
        </div>
        
        <div class="col-md-11 topmargin_l" style="margin-left: 30px;">
            {{ $greeting }}
        </div>
        
        <div class="col-md-4 topmargin_l">
            <a href="" class="btn primary">Give Gift</a>
        </div>
            
        <div class="col-md-4 topmargin_l">
            <a href="" class="btn primary">Quest</a>
        </div>
            
        <div class="col-md-4 topmargin_l">
            <a href="/shop/{{ $shop->id }}/sell" class="btn primary">Sell</a>
        </div>
        
        <div class="col-md-12 topmargin_l">
            @if(!$shop->stock()->count())
                <div class="topmargin_l"><br /><br /><b>There are no items in stock.</b></div>
            @else
                <div class="row">

                    @foreach($shop->stock AS $stock)
                        @if($stock->info()->count())
                        <div class="col-md-2 topmargin_l">
                            <a href="/shop/{{ $shop->id }}/buy/{{ $stock->item_id }}" onclick="return confirm('Are you sure you want to purchase {{ $stock->item->name }} for {{ number_format($stock->info->price) }}s?')"><img src="/assets/images/items/{{ $stock->item->image }}" /></a>
                            <br />
                            <b>{{ $stock->item->name }}</b><br />
                            <b>Qty: {{ $stock->qty }}</b><br />
                            <b>Price: {{ number_format($stock->info->price) }}s</b>
                        </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@stop