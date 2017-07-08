<?php $__env->startSection('title', "| Blog Archive"); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Blog Archive</h1>
        </div>
    </div>

    <?php foreach($posts as $post): ?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2 style="word-break:break-all;word-wrap:break-word;"><?php echo e($post->title); ?></h2>
            <h5>Published: <?php echo e(date('M d, Y', strtotime($post->created_at))); ?></h5>
            <p style="word-break:break-all;word-wrap:break-word;"><?php echo e(mb_substr(strip_tags($post->body), 0, 255)); ?><?php echo e(mb_strlen(strip_tags($post->body)) > 255 ? '......' : ''); ?></p>
            <a href="<?php echo e(route('blog.single', ['slug' => $post->slug])); ?>" class="btn btn-primary">Read More</a>
            <hr>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="text-center"><?php echo e($posts->links()); ?></div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.blogTemplate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>