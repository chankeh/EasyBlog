@extends('layouts/template')

@section('stylesheets')
    <link rel="stylesheet" href="{{ URL::asset('css/navbar.css') }}">
@endsection

@section('body_content')
    <div class="container">
        @include('partials/navbar')
        <h2 style="margin: 15px 0">凤焕亭</h2>

        @section('content')
        @show

        <div class="footer text-center" style="margin: 20px 0 60px 0;">
            @include('partials/_footer')
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/navbar.js') }}"></script>
@endsection