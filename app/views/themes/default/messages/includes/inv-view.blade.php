@if(Auth::user()->items()->count() == 0)
<p>
    You do not have any items.
</p>
@else
@foreach(Auth::user()->items()->get() as $item)
<div class="col-2" data-uuid="{{ $item->id }}" data-item-id="{{ $item->item->id }}" data-quantity="{{ $item->qty }}">
    <img class="align-center item" id="item-image-{{ $item->id }}" src="{{ url('/') }}/assets/images/items/{{ $item->item->image }}" width="40px" height="40px" data-toggle="tooltip" data-placement="right" title="{{ $item->item->description }}" />

    <div>
        <span class="blue-bold">{{ strtoupper($item->item->name) }}</span>
    </div>
</div>
@endforeach
@endif