@extends('layouts.blogTemplate')

@section('content')

    <!-- DevMarketer tutorial main homepage -->
    @include('partials._devMarketerMainHome')

    <div class="loginBox nav navbar-nav pull-right" style="margin-top: 15px;">
        <!-- Authentication Links -->
        @if (Auth::guest())
            <li><a class="btn" href="{{ url('/login') }}">Login</a></li>
            <li><a href="{{ url('/register') }}">Register</a></li>
        @else
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
        @endif
    </div>

    <h1>xiaopo's Blog</h1>

    {{-- menu for different post category organization --}}
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- left side of navbar -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">Sort Posts By<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route("homePage", ['orderBy' => 'Recent']) }}">Top 10 Most Recent Posts</a></li>
                        <li><a href="{{ route("homePage", ['orderBy' => 'Commented']) }}">Top 10 Most Commented Posts</a></li>
                        <li><a href="{{ route("homePage", ['orderBy' => 'Visited']) }}">Top 10 Most Visited Posts</a></li>
                    </ul>
                </li>
            </ul>
            <!-- right side of navbar -->
            @if(Auth::check())
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ url('posts') }}">Manage Posts</a></li>
                </ul>
            @endif
        </div>
    </nav>


    {{-- container for containing top 10 posts in specified Post categories --}}
    <!--
    <div class="well well-lg">
        <h3>Blog Post Title</h3>
        <p>my mother and my gf, my mother and my gf,  my mother and my gf,  my mother and my gf,  my mother and my gf,  my mother and my gf, </p>
    </div>
    -->

    <?php if (isset($orderBy))
        echo "<h3>Top 10 Most $orderBy Posts</h3>";  // <!-- h1 h3也是块级元素 -->
    ?>

    {{-- container for containing top 10 posts in specified Post categories --}}
    @foreach($posts as $post)
        <div class="well well-lg">
            <h3 style="word-break:break-all;word-wrap:break-word;">{{ $post->title }}</h3>
            <p style="word-break:break-all;word-wrap:break-word;">{{ mb_substr(strip_tags($post->body), 0, 300) }}{{ mb_strlen(strip_tags($post->body)) > 300 ? "......" : "" }}</p>  <!-- 因为p也是块级元素，所以要加个空格。 -->
            <br/>
            <br/>
            <p>Visit Count: {{ $post->visit_count }}</p>
            <p>Comment Count: {{ $post->comment_count }}</p>
            <p>Created At: {{ date('F d, Y', strtotime($post->created_at)) }} at {{ date('g:ia', strtotime($post->created_at)) }}</p>
            <p>Updated At: {{ $post->updated_at }}</p>
            <?php
                //$blogTitleSlug = str_slug($post->title, '-');
            ?>
            <a href="{{ route('blog.single', ['slug' => $post->slug]) }}" class="btn btn-default pull-right">Read More</a>
            &nbsp;
        </div>
    @endforeach

    <div class="row text-center">
        {{ $posts->appends(['orderBy' => $orderBy])->links() }}
    </div>

@endsection