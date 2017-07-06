@extends('layouts/template')

@section('body_content')
    <!-- Default Bootstrap Navbar -->
    @include('partials/_bootstrapNav')

    <div class="container">
        @section('content')
        @show

        <div class="footer text-center" style="margin: 20px 0 60px 0;">
            @include('partials/_footer')
        </div>
    </div>
@endsection