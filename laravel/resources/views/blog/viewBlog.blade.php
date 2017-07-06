@extends('layouts.blogTemplate')

@section('stylesheets')
    <link rel="stylesheet" href="{{ URL::asset('css/comment.css') }}">
@endsection


@section('title', "View Blog #$id")

@section('content')

    {{-- facebook comments system sdk script --}}
    <div id="fb-root"></div>


    {{-- disqus comments system to load  step.1 --}}
    <div id="disqus_thread"></div>



    <button onclick="countComment()">Alert Facebook Comment Count</button>
    <div>
        <span class="fb-comments-count" id="fbCommentCount" data-href="{{ Request::url() }}"></span>
    </div>

    <!-- 更新评论数，浏览数 -->
    <form style=""  id="fbCommentCountForm" action="{{ route('blog.update', ['id'=> $id]) }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">

        <input type="text" name="commentCount" id="fbFormCommentCount">
        <input type="text" name="visitCount" id="fbFormVisitCount" value="{{ $post->visit_count }}">
        <input type="submit" name="sbm" value="submit comment count">
    </form>

    <div class="row">
        <a href="http://127.0.0.1/laravel/public/index.php">Go to Home</a>
    </div>
    <div id="postContent" class="row">
        @if (isset($post->featured_image))
            <img src="{{ URL::asset('images/' . $post->featured_image) }}" alt="" width="800px" height="400px">
        @endif
        <h1>{{ $post->title }}</h1> <!-- 注意这两个的区别，原样输出 -->
        <p>{!! $post->body !!}</p> <!-- 注意这两个的区别 -->
        <p>Posted In：{{ $post->category->name }}</p>
        <div class="tags">
            标签：
            @foreach($post->tags as $tag)
                <span class="label label-default">{{ $tag->name }}</span>
            @endforeach
        </div>

        <!-- 评论 -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h3 class="comment-title"><span class="glyphicon glyphicon-comment"></span>&nbsp;{{ $post->comments->count() }}&nbsp;Comments</h3>
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

        <div class="row">
            <div id="comment-form" class="col-md-8 col-md-offset-2" style="margin-top: 50px;">
                <form action="{{ route('comments.store', ['id' => $post->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Name:</label>
                            <input name="name" type="text" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email">Email:</label>
                            <input name="email" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="comment">Comment:</label>
                            <textarea name="comment" id="" cols="15" rows="5" class="form-control"></textarea>
                            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 15px;">Add Comment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end of 评论 -->
    </div>

    <!-- facebook comment system show comment -->
    <div class="row text-center" id="facebookCommentContainer">
        <div class="fb-comments" data-href="{{ Request::url() }}" data-width="800" data-numposts="10"></div>  <!-- 宽度800 每页10个评论 -->
                                                   <!-- 这样也可以data-href="http://127.0.0.1/laravel/public/index.php/posts/$id }}" -->
    </div>
@endsection


@section('scripts')
    {{-- facebook comments system sdk script --}}
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/zh_CN/sdk.js#xfbml=1&version=v2.8";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    {{-- disqus comments system to load   step.2 --}}
    {{-- IMPORTANT: Replace EXAMPLE with your forum shortname! --> --}}
    <script>

        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
        /*
         var disqus_config = function () {
         this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
         this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
         };
         */
        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://xiaopo-me.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <script id="dsq-count-scr" src="//xiaopo-me.disqus.com/count.js" async></script>


    <script>

        /*
         $(document).ready(function() {



         });
         */

        /* 这种写法错误!
         $(window).load(function () {
         console.log('2');
         });
         */
        //$(window).on("load", function (e) {alert(2);}); // 这种写法正确!


        var fbCommentCount = document.getElementById('fbCommentCount').getElementsByClassName('fb_comments_count');
        function countComment() {
            alert(fbCommentCount[0].innerHTML);
        }

        //ajax更新评论数，浏览数
        setTimeout(function() {
            //更新评论数。
            document.getElementById('fbFormCommentCount').value = fbCommentCount[0].innerHTML; //要花时间等待变换成<span>3</span>，否则<span></span>取不出来。
            //更新浏览数，+1。
            var visitCount = document.getElementById('fbFormVisitCount').value;
            //等价于 var visitCount = document.getElementById('fbFormVisitCount').attributes['value'].nodeValue;
            document.getElementById('fbFormVisitCount').value = (parseInt(visitCount)+1).toString();

            var $formVar = $('form');

            $.ajax({
                url: $formVar.prop('{{ route('blog.update', ['slug' => $post->slug]) }}'),
                method: 'PUT',
                data: $formVar.serialize()
                /*
                 headers: {
                 "Content-Type": "application/json",
                 "X-HTTP-Method-Override": "PUT" ,
                 },
                 */
            });
        }, 5000); //所花时间为5秒

    </script>

@endsection