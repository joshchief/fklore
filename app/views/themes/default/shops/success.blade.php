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
            <img src="/assets/images/items/{{ $item->image }}" />
            <h3>Thank you for your purchase! <b>{{ $item->name }}</b> has been added to your <a href="/user/inventory" style="color: #0056c3;">inventory</a>!</h3>
            
            <h3><a href="/shop/{{ $shop->id }}" style="color: #0056c3;">Return to {{ $shop->name }}</a></h3>
        </div>
        
        
    </div>
@stop