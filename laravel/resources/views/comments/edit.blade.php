@extends('layouts.template')

@section('title', 'Edit #'.$comment->id.' Comment')

@section('body_content')
    <h1>Edit #{{ $comment->id }} Comment</h1>
    <form action="{{ route('comments.update', ['id' => $comment->id]) }}" method="post" data-parsley-validate>
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT" />

        <div class="form-group">
            <label for="name">Name:</label>
            <input name="name" type="text" class="form-control" value="{{ $comment->name }}" disabled>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input name="email" type="text" class="form-control" value="{{ $comment->email }}" disabled>
        </div>

        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea name="comment" id="" cols="30" rows="10" class="form-control">{{ $comment->comment }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Comment</button>
        <a href="{{ route('posts.show', ['id' => $comment->post->id]) }}" class="btn btn-default pull-right">Go Back</a>

    </form>
@endsection