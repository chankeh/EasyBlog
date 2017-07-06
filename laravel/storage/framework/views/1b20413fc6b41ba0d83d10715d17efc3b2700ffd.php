<?php $__env->startSection('body_content'); ?>
    <!-- Default Bootstrap Navbar -->
    <?php echo $__env->make('partials/_bootstrapNav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="container">
        <?php $__env->startSection('content'); ?>
        <?php echo $__env->yieldSection(); ?>

        <div class="footer text-center" style="margin: 20px 0 60px 0;">
            <?php echo $__env->make('partials/_footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>