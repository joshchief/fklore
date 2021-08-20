@extends('themes.default.layout')

@section('content')
    <div class="row align-center topmargin_l">
        <div class="col-12 header-text">
            My Inventory
        </div>
        
        <div class="col-12 sub-header topmargin_l">
            Your inventory is currently size {{ number_format(Auth::user()->inventory_size) }} and can hold 50 unique items.
        </div>
    </div>
    
    <div class="row topmargin_l">
        @if(Auth::user()->items()->count())
            <div class="col-12">
                <div class="row" style="padding-left: 30px; padding-right: 30px;">
                    @foreach($items AS $item)
                        <div class="col-2 topmargin_l">
                            <div class="item-contain align-center">
                                <img src="/assets/images/items/{{ $item->item->image }}" width="90px" height="90px" data-toggle="tooltip" data-placement="right" title="{{ $item->item->description }}" />
                                <div class="item-qty">
                                    x{{ $item->qty }}
                                </div>
                            </div>
                            
                            <div>
                                <span class="blue-bold">{{ strtoupper($item->item->name) }}</span>
                            </div>
                            
                            <div>
                                <span class="grey-italic">{{ ucfirst($item->item->item_use) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="col-12 align-center">
                <b>You do not have any items.</b>
            </div>
        @endif
    </div>
    
    <div class="row topmargin_l" style="padding-left: 30px; padding-right: 30px;">
        <div class="col-5">
            <a href="#" class="btn danger form-control">Expand Inventory</a>
        </div>
        
        <div class="col-7 align-right" style="bottom: -20px;">
            @if(Auth::user()->items()->count())
            <span class="blue-bold">Browsing Page {{ $items->getCurrentPage() }} of {{ $items->getLastPage() }}</span> 
            
                @if($items->getCurrentPage() != $items->getLastPage()) <a class="blue-bold" href="/user/inventory?page={{ ($items->getCurrentPage() + 1) }}">[Next]</a> @endif
                
                 @if($items->getCurrentPage() != 1) <a class="blue-bold" href="/user/inventory?page={{ ($items->getCurrentPage() - 1) }}">[Previous]</a> @endif
                 
                 <a class="blue-bold" href="/user/inventory?page={{ $items->getLastPage() }}">[Last]</a>
            @else
                <span class="blue-bold">Browsing Page 1 of 1</span> 
            @endif
        </div>
    </div>
@stop