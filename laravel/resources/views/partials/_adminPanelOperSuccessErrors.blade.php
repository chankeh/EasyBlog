<div class="row">
    @if (null !== \Illuminate\Support\Facades\Session::get('success'))
        <div class="alert alert-success" role="alert">
            <strong>Success:</strong> {{ \Illuminate\Support\Facades\Session::get('success') }}
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            <strong>Errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>