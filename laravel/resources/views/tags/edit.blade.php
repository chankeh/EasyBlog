@extends('layouts.template')

@section('title', '| Edit Tag #'.$tag->id.' '.$tag->name)


@section('body_content')
    <form action="{{ route('tags.update', ['id' => $tag->id]) }}" method="post" data-parsley-validate>
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT" />

        <div class="form-group">
            <label for="name">Name:</label>
            <input name="name" type="text" class="form-control" value="{{ $tag->name }}" required maxlength='255'>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
@endsection