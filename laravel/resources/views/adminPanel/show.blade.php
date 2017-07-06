@extends('layouts.template')

@section('title', '| View Post')

@section('body_content')
    <div class="container">
        @include('partials._adminPanelOperSuccessErrors')
        <div class="row">
            <div class="col-md-8">
                @if (isset($post->featured_image))
                    <img src="{{ URL::asset('images/' . $post->featured_image) }}" alt="" width="800px" height="400px">
                @endif

                <h1 style="word-break:break-all;word-wrap:break-word;">{{ $post->title }}</h1>
                <p class="lead" style="word-break:break-all;word-wrap:break-word;">{!! $post->body !!}</p>

                <hr>

                <div class="tags">
                    标签：
                    @foreach($post->tags as $tag)
                        <span class="label label-default">{{ $tag->name }}</span>
                    @endforeach
                </div>

                <!-- 后台评论显示 -->
                <div id="backend-comments" style="margin-top: 50px;">
                    <h3>Comments <small>{{ $post->comments->count() }} total</small></h3>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Comment</th>
                            <th width="70px"></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($post->comments as $comment)
                            <tr>
                                <td>{{ $comment->name }}</td>
                                <td>{{ $comment->email }}</td>
                                <td>{{ $comment->comment }}</td>
                                <td>
                                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a href="{{ route('comments.delete', $comment->id) }}" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end of 后台评论显示 -->

            </div>

            <!-- sidebar room -->
            <div class="col-md-4">
                <div class="well">
                    <!-- definition list title description-->
                    <dl class="dl-horizontal">
                        <dt>Url:</dt>
                        <dd><a href="{{ url('blog/' . $post->slug) }}"> {{ $post->slug }} </a></dd>
                    </dl>

                    <dl class="dl-horizontal">
                        <dt>Category:</dt>
                        <dd>{{ $post->category_id ? $post->category->name : 'Null' }}</dd>
                    </dl>

                    <dl class="dl-horizontal">
                        <dt>Created At:</dt>
                        <dd>{{ $post->created_at }}</dd>
                    </dl>

                    <dl class="dl-horizontal">
                        <dt>Updated At:</dt>
                        <dd>{{ date('M j, Y h:iA', strtotime($post->updated_at)) }}</dd>
                    </dl>

                    <hr/>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="btn btn-primary btn-block">Edit</a>
                        </div>
                        <div class="col-sm-6">
                            <form action="{{ route('posts.destroy', ['id'=> $post->id]) }}" method="POST" class="pull-right" style="width:100%;">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="submit" value='Delete' class="btn btn-danger" style="width:100%;">
                            </form>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 12px;">
                        <div class="col-sm-12">
                            <a href="{{ route('posts.index') }}" class="btn btn-default btn-block">&lt;&lt; See All Posts</a>
                        </div>
                    </div>
                </div>
            </div> <!-- end of sidebar room-->
        </div>
    </div>

@endsection