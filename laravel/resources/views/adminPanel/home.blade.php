@extends('layouts.template')

@section('title', 'Blog Admin Panel')

@section('body_content')
    <div class="container">
        <!-- 总面板开始 -->
        <div class="row">
            <div class="col-md-12">
                <div class="nav navbar-nav pull-right" style="margin-top: 15px;">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" style="display: none;">  <!-- POST提交方式,后来发现没必要用POST啊 -->
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                </div>

                <h1>Admin Panel</h1>
            </div>
        </div>
        <!-- 总面板结束 -->
        <hr/>

        @include('partials._adminPanelOperSuccessErrors')

        <!-- 子面板开始 -->
        <div class="row">
            <div class="col-md-10">
                <h2>All Posts</h2>
            </div>
            <div class="col-md-2">
                <a href="{{ route('posts.create') }}" class="btn btn-primary pull-right" style="margin-top: 20px;">Add New Blog Post</a>
            </div>
        </div>
        <!-- 子面板结束 -->

        <!-- 内容开始 -->
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <th>id</th>
                        <th>title</th>
                        <th>body</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <th>{{ $post->id }}</th>
                                <td>
                                    {{ mb_substr($title=$post->title, 0, 30, 'utf-8') }}
                                    @if (mb_strlen($title) > 30)
                                        {{ '......' }}
                                    @endif
                                </td>
                                <td>
                                    {{ mb_substr($body=strip_tags($post->body), 0, 50, 'utf-8') }}
                                    @if (mb_strlen($body) > 50)
                                        {{ '......' }}
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('posts.destroy', ['id'=> $post->id]) }}" method="POST" class="pull-right">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="submit" value='Delete' class="btn btn-danger">
                                    </form>
                                    <a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="btn btn-info pull-right">Edit</a>
                                    <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="btn btn-success pull-right">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- 内容结束 -->
    </div>

@endsection