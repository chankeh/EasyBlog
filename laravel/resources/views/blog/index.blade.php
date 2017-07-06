@extends('layouts.blogTemplate')

@section('title', "| Blog Archive")

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Blog Archive</h1>
        </div>
    </div>

    @foreach($posts as $post)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2 style="word-break:break-all;word-wrap:break-word;">{{ $post->title }}</h2>
            <h5>Published: {{ date('M d, Y', strtotime($post->created_at)) }}</h5>
            <p style="word-break:break-all;word-wrap:break-word;">{{ mb_substr(strip_tags($post->body), 0, 255) }}{{ mb_strlen(strip_tags($post->body)) > 255 ? '......' : '' }}</p>
            <a href="{{ route('blog.single', ['slug' => $post->slug]) }}" class="btn btn-primary">Read More</a>
            <hr>
        </div>
    </div>
    @endforeach

    <div class="row">
        <div class="col-md-12">
            <div class="text-center">{{ $posts->links() }}</div>
        </div>
    </div>

@endsection