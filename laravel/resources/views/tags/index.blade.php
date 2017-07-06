@extends('layouts.template')

@section('title', '| All Tags')


@section('body_content')

    @include('partials/_adminPanelOperSuccessErrors')

    <div class="row">
        <div class="col-md-8">
            <h1>Tags</h1>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                </tr>
                </thead>

                <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <th>{{ $tag->id }}</th>
                        <td><a href="{{ route('tags.show', ['id' => $tag->id]) }}" class="">{{ $tag->name }}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div> <!-- end of .col-md-8 -->

        <div class="col-md-4">
            <div class="well">
                <h2>New Tag</h2>

                <form action="{{ route('tags.store') }}" method="post" data-parsley-validate>  <!-- 看action看method -->
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input name="name" type="text" class="form-control" required maxlength='255'>
                    </div>

                    <button type="submit" class="btn btn-primary">Create New Tag</button>

                </form>
            </div>
        </div>
    </div>

@endsection