<?php $__env->startSection('content'); ?>
    <?php if (isset($orderBy))
        echo "<h3>Top 10 Most $orderBy Posts</h3>";  // <!-- h1 h3也是块级元素 -->
    ?>

    <?php /* container for containing top 10 posts in specified Post categories */ ?>
    <?php foreach($posts as $post): ?>
        <div class="well well-lg">
            <h3><?php echo e($post->title); ?></h3>
            <p><?php echo e($post->body); ?></p>  <!-- 因为p也是块级元素，所以要加个空格。 -->
            <br/>
            <br/>
            <p>Visit Count: <?php echo e($post->visit_count); ?></p>
            <p>Comment Count: <?php echo e($post->comment_count); ?></p>
            <p>Created At: <?php echo e(date('F d, Y', strtotime($post->created_at))); ?> at <?php echo e(date('g:ia', strtotime($post->created_at))); ?></p>
            <p>Updated At: <?php echo e($post->updated_at); ?></p>
            <a href="<?php echo e(route('posts.show', ['id' => $post->id])); ?>" class="btn btn-default pull-right">View Post</a>
            &nbsp;
        </div>
    <?php endforeach; ?>
    <div class="row text-center">
        <?php echo e($posts->appends(['orderBy' => $orderBy])->links()); ?>

    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.publicHomePageTemplate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>