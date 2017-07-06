<?php $__env->startSection('content'); ?>

    <!-- DevMarketer tutorial main homepage -->
    <?php echo $__env->make('partials/_devMarketerMainHome', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="loginBox nav navbar-nav pull-right" style="margin-top: 15px;">
        <!-- Authentication Links -->
        <?php if(Auth::guest()): ?>
            <li><a class="btn" href="<?php echo e(url('/login')); ?>">Login</a></li>
            <li><a href="<?php echo e(url('/register')); ?>">Register</a></li>
        <?php else: ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="<?php echo e(url('/logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="<?php echo e(url('/logout')); ?>" style="display: none;">  <!-- POST提交方式,后来发现没必要用POST啊 -->
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </li>
                </ul>
            </li>
        <?php endif; ?>
    </div>

    <h1>xiaopo's Blog</h1>

    <?php /* menu for different post category organization */ ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- left side of navbar -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">Sort Posts By<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo e(route("homePage", ['orderBy' => 'Recent'])); ?>">Top 10 Most Recent Posts</a></li>
                        <li><a href="<?php echo e(route("homePage", ['orderBy' => 'Commented'])); ?>">Top 10 Most Commented Posts</a></li>
                        <li><a href="<?php echo e(route("homePage", ['orderBy' => 'Visited'])); ?>">Top 10 Most Visited Posts</a></li>
                    </ul>
                </li>
            </ul>
            <!-- right side of navbar -->
            <?php if(Auth::check()): ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo e(url('posts')); ?>">Manage Blog Posts</a></li>
                </ul>
            <?php endif; ?>
        </div>
    </nav>


    <?php /* container for containing top 10 posts in specified Post categories */ ?>
    <!--
    <div class="well well-lg">
        <h3>Blog Post Title</h3>
        <p>my mother and my gf, my mother and my gf,  my mother and my gf,  my mother and my gf,  my mother and my gf,  my mother and my gf, </p>
    </div>
    -->

    <?php if (isset($orderBy))
        echo "<h3>Top 10 Most $orderBy Posts</h3>";  // <!-- h1 h3也是块级元素 -->
    ?>

    <?php /* container for containing top 10 posts in specified Post categories */ ?>
    <?php foreach($posts as $post): ?>
        <div class="well well-lg">
            <h3 style="word-break:break-all;word-wrap:break-word;"><?php echo e($post->title); ?></h3>
            <p style="word-break:break-all;word-wrap:break-word;"><?php echo e(mb_substr($post->body, 0, 300)); ?><?php echo e(mb_strlen($post->body) > 300 ? "......" : ""); ?></p>  <!-- 因为p也是块级元素，所以要加个空格。 -->
            <br/>
            <br/>
            <p>Visit Count: <?php echo e($post->visit_count); ?></p>
            <p>Comment Count: <?php echo e($post->comment_count); ?></p>
            <p>Created At: <?php echo e(date('F d, Y', strtotime($post->created_at))); ?> at <?php echo e(date('g:ia', strtotime($post->created_at))); ?></p>
            <p>Updated At: <?php echo e($post->updated_at); ?></p>
            <a href="<?php echo e(route('viewPost', ['id' => $post->id])); ?>" class="btn btn-default pull-right">View Post</a>
            &nbsp;
        </div>
    <?php endforeach; ?>

    <div class="row text-center">
        <?php echo e($posts->appends(['orderBy' => $orderBy])->links()); ?>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/blogTemplate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>