@extends('layouts.template')

@section('title', 'Tags #'.$tag->id.' '.$tag->name)


@section('body_content')
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $tag->name }} Tag <small>{{ $tag->posts()->count() }} Posts</small></h1>
        </div>
        <div class="col-md-2">
            <a href="{{ route('tags.edit', ['id' => $tag->id]) }}" class="btn btn-primary btn-block pull-right" style="margin-top: 20px;">Edit</a>
        </div>
        <div class="col-md-2">
            <form action="{{ route('tags.destroy', ['id'=> $tag->id]) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" value='Delete' class="btn btn-danger" style="width:100%;margin-top: 20px;">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <!-- tr: table row-->
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Tags</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($tag->posts as $post)
                        <tr>
                            <th>{{ $post->id }}</th>
                            <td>{{ $post->title }}</td>
                            <td>
                                @foreach($post->tags as $postTag)
                                    <span class="label label-default">{{ $postTag->name }}</span>
                                @endforeach
                            </td>
                            <td><a href="{{ route('posts.show', ['id' => $post->id]) }}" class="btn btn-default btn-xs">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection