@extends('layouts.blogTemplate')

@section('content')


    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <img src="{{ URL::asset('banner/1183-300-1.JPG') }}" alt="Chicago">
            </div>

            <div class="item">
                <img src="{{ URL::asset('banner/1183-300-2.JPG') }}" alt="New York">
            </div>
        </div>
    </div>


    <div class="row" style="margin-top: 30px">
        <div class="col-md-4">
            {{-- menu for different post category organization --}}
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- left side of navbar -->
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">分类阅读<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route("homePage", ['orderBy' => 'Recent']) }}">Top 10 Most Recent Posts</a></li>
                                <li><a href="{{ route("homePage", ['orderBy' => 'Commented']) }}">Top 10 Most Commented Posts</a></li>
                                <li><a href="{{ route("homePage", ['orderBy' => 'Visited']) }}">Top 10 Most Visited Posts</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="panel panel-default">
                <div class="panel-heading">标签</div>
                <div class="panel-body">
                    @if($tags->count() > 0)
                        @foreach( $tags as $tag)
                            <a href="#"
                               style="font-size: {{ mt_rand(12,30) }}px;color:rgb({{ mt_rand(0,255) }}, {{ mt_rand(0,255) }}, {{ mt_rand(0,255) }});"
                            >{{ $tag->name }}</a>
                        @endforeach
                    @else
                        <h4>暂时没有标签哦~</h4>
                    @endif
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">评论排行榜</div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        @if($postCommented10->count() > 0)
                            @foreach($postCommented10 as $post)
                                <li style="margin-top: 20px"><a href="{{ route('blog.single', ['slug' => $post->slug]) }}">{{ mb_substr($post->title, 0, 30, 'utf-8') }} {{ mb_strlen($post->title) > 30 ? '......' : '' }}</a></li>
                            @endforeach
                        @else
                            <h4>暂时没有文章哦~~</h4>
                        @endif
                    </ul>
                </div>
            </div>

        </div>

        <div class="col-md-8">
            {{-- container for containing top 10 posts in specified Post categories --}}
            @foreach($posts as $post)
                <div class="well well-lg">
                    <h3 style="word-break:break-all;word-wrap:break-word;">{{ $post->title }}</h3>
                    <p style="word-break:break-all;word-wrap:break-word;">{{ mb_substr(strip_tags($post->body), 0, 300) }}{{ mb_strlen(strip_tags($post->body)) > 300 ? "......" : "" }}</p>  <!-- 因为p也是块级元素，所以要加个空格。 -->
                    <br>
                    <br>

                    <?php
                    //$blogTitleSlug = str_slug($post->title, '-');
                    ?>
                    <a href="{{ route('blog.single', ['slug' => $post->slug]) }}" class="btn btn-default pull-right">更多</a>
                    &nbsp;
                </div>
            @endforeach
            <div class="row text-center">
                {{ $posts->appends(['orderBy' => $orderBy])->links() }}
            </div>
        </div>
    </div>

@endsection