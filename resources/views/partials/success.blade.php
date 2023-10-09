@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('flash-' . $msg))
        <div class="alert alert-{{ $msg }} text-center" role="alert">
           <h5> {{ Session::get('flash-' . $msg) }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
           </h5>
        </div>
    @endif
@endforeach