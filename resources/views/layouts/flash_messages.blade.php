{{--THIS IS BOOTSTRAP 4 CLASSES.--}}
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))

            <div class="alert alert-{{ $msg }}" role="alert">
                {{ Session::get('alert-' . $msg) }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
    @endforeach
</div> <!-- end .flash-message -->