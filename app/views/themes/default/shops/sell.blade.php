@extends('themes.default.layout')
    
@section('content')
    {{ Form::open() }}
    <div class="row align-center">
        <div class="col-md-12">
            <h1><span style="color: #355b7d;"><b>{{ $shop->name }}</span></b></h1>
        </div>
        
        <div class="col-md-12">
            <img src="/assets/images/shops/{{ $shop->image }}" />
        </div>
        
        <div class="col-md-12 topmargin_l">
            {{ Form::label('item', 'Select Item:') }}
			<select name="item">
				@foreach(Auth::user()->items AS $item)
				    <option value="{{ $item->item_id }}">{{ ucfirst($item->item->name) }} (Value: {{ number_format($item->item->sell_price)   }}) (Qty: {{ number_format($item->qty) }})</option>
				@endforeach
			</select>
        </div>
        
        <div class="col-md-12 topmargin_l" >
            {{ Form::label('qty', 'Qty:') }}
			{{ Form::text('qty', 1) }}
        </div>
        
        <div class="col-md-12 topmargin_l">
                <button type="submit" value="1" class="btn primary">Sell</button>
        </div>
        
        <div class="col-md-12 topmargin_l">
            <h3><a href="/shop/{{ $shop->id }}" style="color: #0056c3;">Return to {{ $shop->name }}</a></h3>
        </div>
    </div>
    {{ Form::close() }}
@stop