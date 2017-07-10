<?php $__env->startSection('body_content'); ?>
    <div class="container">
        <?php echo $__env->make('partials/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <h2 style="margin: 15px 0"><a href="http://127.0.0.1/laravel/public/index.php" style="text-decoration: none;color:black;">凤焕亭</a></h2>

        <?php $__env->startSection('content'); ?>
        <?php echo $__env->yieldSection(); ?>

        <div class="footer text-center" style="margin: 20px 0 60px 0;">
            <?php echo $__env->make('partials/_footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>