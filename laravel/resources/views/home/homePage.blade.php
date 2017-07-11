@extends('layouts.blogTemplate')

@section('stylesheets')
    <style type="text/css">
        ul:not(.browser-default) li {
            list-style-type: none;
        }
        li {
            display: list-item;
            text-align: -webkit-match-parent;
        }

        .not-bs-panel>ul{
            padding: 0;
            margin: 50px 0;
        }
        .not-bs-panel>ul>li{
            margin: 0px;
            padding: 5px 0;
        }
        .not-bs-panel>ul>a{
            margin-top: 5px;
        }
        .not-bs-panel>ul>.side-title{
            color: black;
            font-size: 20px;
            font-weight: bold;
            padding-bottom: 10px;
        }

        #hot-post-text{
            color: #616161 !important;
        }
        #hot-post-text:hover{
            text-decoration: underline;
        }

        a{
            text-decoration: none;
            -webkit-tap-highlight-color: transparent;
            background-color: transparent;
        }



    </style>
@endsection

@section('content')

    <!-- 图片轮播 Carousel-->
    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="5000" data-pause="true">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <img src="{{ URL::asset('banner/1183-300-0.JPG') }}">
            </div>
            <div class="item">
                <img src="{{ URL::asset('banner/1183-300-1.JPG') }}">
            </div>
            <div class="item">
                <img src="{{ URL::asset('banner/1183-300-2.JPG') }}">
            </div>
        </div>
    </div>


    <div class="row" style="margin-top: 30px">
        <div class="col-md-3">

            <div class="not-bs-panel">
                <ul style="margin: 0 0 50px 0;">
                    <li class="side-title">目录</li>
                    @if($categories->count() > 0)
                        <div class="list-group">
                        @foreach( $categories as $category)
                                <a href="{{ route('homePage', ['categoryId' => $category->id]) }}" class="list-group-item" style="border: 0; padding-left: 0;">
                                    <span class="glyphicon "></span> {{ $category->name }} <span class="badge" style="background-color: #5bc0de; margin-right: 37px;">{{ $category->count }}</span>
                                </a>
                        @endforeach
                        </div>
                    @endif
                </ul>
            </div>

            <div class="not-bs-panel">
                <ul>
                    <li class="side-title">标签</li>
                    @if($tags->count() > 0)
                        @foreach( $tags as $tag)
                            <a href="{{ route('homePage', ['tagId' => $tag->id]) }}"
                               style="font-size: {{ mt_rand(12,30) }}px;color:rgb({{ mt_rand(0,255) }}, {{ mt_rand(0,255) }}, {{ mt_rand(0,255) }});"
                            >{{ $tag->name }}</a>
                        @endforeach
                    @endif
                </ul>
            </div>

            <div class="not-bs-panel">
                <ul>
                    <li class="side-title">评论排行榜</li>
                    @if($postCommented10->count() > 0)
                        @foreach($postCommented10 as $post)
                            <li><a id="hot-post-text" href="{{route('blog.single', $post->slug)}}">{{ $post->title }}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>

        </div>

        <div class="col-md-9">
            {{-- container for containing top 10 posts in specified Post categories --}}
            @foreach($posts as $post)
                <div style="margin: 0 0 60px 0;">
                    <div style="margin: 0 0 30px 0;padding: 0;">
                        <h3 style="word-break:break-all;word-wrap:break-word;">{{ $post->title }}</h3>
                        <!-- 标签 -->
                        @if($post->tags->count() > 0)
                            标签:
                            @foreach($post->tags as $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        @endif
                    </div>
                    <p style="word-break:break-all;word-wrap:break-word;">{{ mb_strlen(strip_tags($post->body)) > 300 ? mb_substr(strip_tags($post->body), 0, 300).'......' : strip_tags($post->body) }}</p>
                    <a href="{{ route('blog.single', ['slug' => $post->slug]) }}">阅读全文</a>  <!-- 因为p也是块级元素，所以要加个空格。 -->
                    <br>
                    <br>
                    <br>
                </div>
            @endforeach
            <div class="row text-center">
                {{ $posts->appends(['orderBy' => $orderBy, 'categoryId' => $categoryId, 'tagId' => $tagId])->links() }}
            </div>
        </div>
    </div>

@endsection