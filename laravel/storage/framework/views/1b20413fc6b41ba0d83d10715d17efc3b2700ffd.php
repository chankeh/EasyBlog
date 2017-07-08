<?php $__env->startSection('stylesheets'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('css/navbar.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body_content'); ?>
    <div class="container">
        <?php echo $__env->make('partials/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <h2 style="margin: 15px 0">凤焕亭</h2>

        <?php $__env->startSection('content'); ?>
        <?php echo $__env->yieldSection(); ?>

        <div class="footer text-center" style="margin: 20px 0 60px 0;">
            <?php echo $__env->make('partials/_footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(URL::asset('js/navbar.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>