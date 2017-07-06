
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">XiaoPo's Blog</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="http://127.0.0.1/laravel/public/index.php">主页 <span class="sr-only">(current)</span></a></li>
                <li class="{{ Request::is('/blog') ? 'active' : '' }}"><a href="http://127.0.0.1/laravel/public/index.php/blog">博客<span class="sr-only">(current)</span></a></li>
                <li class="{{ Request::is('about') ? 'active' : '' }}"><a href="http://127.0.0.1/laravel/public/index.php/aboutMe">关于</a></li> <!-- href="/about"这种形式需用php artisan serve命令启动localhost:8080/about访问 -->
                <li class="{{ Request::is('contact') ? 'active' : '' }}"><a href="http://127.0.0.1/laravel/public/index.php/contact">联系</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="请输入关键字">
                </div>
                <button type="submit" class="btn btn-default">搜索</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Link</a></li>
                @if (Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">你好 {{ Auth::user()->name }}<span class="caret"></span></a> <!-- Auth::user()->email等等都是可以的，和数据库中字段对应 -->
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('posts.index') }}">Posts</a></li>
                            <li><a href="{{ route('categories.index') }}">Categories</a></li>
                            <li><a href="{{ route('tags.index') }}">Tags</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ url('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @else
                    <a href="{{ url('login')}}" class="btn btn-default">Login</a>
                    <a href="{{ url('register')}}" class="btn btn-default">Register</a>
                @endif

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>