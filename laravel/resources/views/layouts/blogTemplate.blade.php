@extends('layouts/template')

@section('body_content')
    <div class="container">
        @include('partials/navbar')
        <h2 style="margin: 15px 0"><a href="/" style="text-decoration: none;color:black;">凤焕亭</a></h2>

        @section('content')
        @show

        <div class="footer text-center" style="margin: 20px 0 60px 0;">
            @include('partials/_footer')
        </div>
    </div>
@endsection