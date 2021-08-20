@extends('themes.default.layout')
    
@section('content')
    <div class="row align-center">
        <div class="col-md-12">
            <h1><span style="color: #355b7d;"><b>{{ $shop->name }}</span></b></h1>
        </div>
        
        <div class="col-md-12">
            <img src="/assets/images/shops/{{ $shop->image }}" />
        </div>
        
        <div class="col-md-11 topmargin_l" style="margin-left: 30px;">
            @if($qty >= 1)
            <img src="/assets/images/items/{{ $item->image }}" />
            
            <h3>You have sold <b>{{ $item->name }} (x{{ number_format($qty) }})</b> for <b>{{ number_format($qty * $item->sell_price) }}</b>!</h3>
            @else
                <h3><b>Invalid Qty!</b></h3>
            @endif
            
            <h3><a href="/shop/{{ $shop->id }}" style="color: #0056c3;">Return to {{ $shop->name }}</a></h3>
        </div>
        
        
    </div>
@stop