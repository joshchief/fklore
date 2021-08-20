@if(Session::has('msg'))
    <div class="alert alert-{{ Session::get('msg')['t'] }}">
        <?php $label = (Session::get('msg')['t'] == 'danger') ? 'Error' : ucfirst(Session::get('msg')['t']); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ $label }}</strong>: {{ Session::get('msg')['m'] }}
        @if(isset(Session::get('msg')['e']))
            <ul style="list-style: none;">
                @foreach(Session::get('msg')['e'] as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        @endif

    </div>
    {{ Session::forget('msg') }}
@endif 