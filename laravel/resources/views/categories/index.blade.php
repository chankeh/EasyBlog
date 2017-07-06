@extends('layouts.template')

@section('title', '| All Categories')


@section('body_content')

    @include('partials/_adminPanelOperSuccessErrors')

    <div class="row">
        <div class="col-md-8">
            <h1>Categories</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <th>{{ $category->id }}</th>
                            <td>{{ $category->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> <!-- end of .col-md-8 -->

        <div class="col-md-4">
            <div class="well">
                <h2>New Category</h2>

                <form action="{{ route('categories.store') }}" method="post" data-parsley-validate>  <!-- 看action看method -->
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input name="name" type="text" class="form-control" required maxlength='255'>
                    </div>

                    <button type="submit" class="btn btn-primary">Create New Category</button>

                </form>
            </div>
        </div>
    </div>

@endsection