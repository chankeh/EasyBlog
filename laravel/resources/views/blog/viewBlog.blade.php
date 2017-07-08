@extends('layouts.blogTemplate')

@section('stylesheets')
    <link rel="stylesheet" href="{{ URL::asset('css/comment.css') }}">
@endsection


@section('title', "View Blog #$id")

@section('content')


    <!-- 更新浏览数 -->
    <form style=""  id="fbCommentCountForm" action="{{ route('blog.update', ['id'=> $id]) }}" method="POST" style="display: none;">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <input type="text" name="visitCount" id="fbFormVisitCount" value="{{ $post->visit_count }}" style="display: none;">
        <input type="submit" name="sbm" value="submit comment count" style="display: none;">
    </form>


    <div id="postContent" class="row">

        <!-- 博客显示 -->
        <div class="col-md-8 col-md-offset-2" style="margin-top: 50px;">
            @if (!is_null($post->featured_image))
                <img src="{{ URL::asset('images/' . $post->featured_image) }}" alt="" width="800px" height="400px">
            @endif
            <h1>{{ $post->title }}</h1> <!-- 注意这两个的区别，原样输出 -->
            <small>{{ date('Y-n-j G:i', strtotime($post->created_at)) }}&nbsp;&nbsp;浏览:{{ $post->visit_count }}次&nbsp;&nbsp;评论:{{ $post->comments->count() }}次</small>
            <br>
            <br>
            <p>{!! $post->body !!}</p> <!-- 注意这两个的区别 -->
            <br>
            <br>
            <p>发布于：{{ $post->category->name }}</p>
            <div class="tags">
                标签：
                @foreach($post->tags as $tag)
                    <span class="label label-default">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>

        <!-- 评论显示 -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2" style="margin-top: 50px;">
                <h3 class="comment-title"><span class="glyphicon glyphicon-comment"></span>&nbsp;{{ $post->comments->count() }}&nbsp;评论</h3>
                @foreach($post->comments as $comment)
                    <div class="comment">
                        <div class="author-info">
                            <img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))) . "?s=50&d=monsterid" }}" alt="" class="author-image">
                            <div class="author-name">
                                <h4>{{ $comment->name }}</h4>
                                <p>{{ date('F nS, Y-g:iA', strtotime($comment->created_at)) }}&nbsp;&nbsp;&nbsp;{{ $comment->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="comment-content">
                            {{ $comment->comment }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 评论框 -->
        <div class="row">
            <div id="comment-form" class="col-md-8 col-md-offset-2" style="margin-top: 50px;">
                <form action="{{ route('comments.store', ['id' => $post->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">姓名:</label>
                            <input name="name" type="text" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email">邮箱:</label>
                            <input name="email" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="comment">内容:</label>
                            <textarea name="comment" id="" cols="15" rows="5" class="form-control"></textarea>
                            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 15px;">添加评论</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection


@section('scripts')

    <script>

        //ajax更新浏览数
        setTimeout(function() {
            //更新浏览数，+1。
            var visitCount = document.getElementById('fbFormVisitCount').value;
            //等价于 var visitCount = document.getElementById('fbFormVisitCount').attributes['value'].nodeValue;
            document.getElementById('fbFormVisitCount').value = (parseInt(visitCount)+1).toString();

            var $formVar = $('form');

            $.ajax({
                url: $formVar.prop('{{ route('blog.update', ['slug' => $post->slug]) }}'),
                method: 'PUT',
                data: $formVar.serialize()
            });
        }, 5000); //延迟等待5秒

    </script>

@endsection