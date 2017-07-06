@extends('layouts.template')

@section('title', '| DELETE COMMENT?')

@section('body_content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>DELETE THIS COMMENT?</h1>
            <p>
                <strong>Name:</strong> {{ $comment->name }}<br>
                <strong>Email:</strong> {{ $comment->email }}<br>
                <strong>Comment:</strong> {{ $comment->comment }}
            </p>

            <form action="{{ route('comments.destroy', ['id' => $comment->id]) }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" value="YES DELETE THIS COMMENT" class="btn btn-lg btn-block btn-danger">
            </form>
        </div>
    </div>
@endsection