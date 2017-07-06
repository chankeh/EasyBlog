<?php $__env->startSection('body_content'); ?>

<!-- Default Bootstrap Navbar -->
<?php echo $__env->make('partials/_bootstrapNav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<div class="container">

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
    <?php $__env->startSection('content'); ?>
    <?php echo $__env->yieldSection(); ?>

    <div class="footer text-center" style="margin: 20px 0 60px 0;">
        <?php echo $__env->make('partials/_footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

</div> <!-- end of .container -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>