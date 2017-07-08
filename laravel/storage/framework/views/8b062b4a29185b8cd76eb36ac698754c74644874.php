<!doctype html>
<html lang="en">
<head>
    <?php echo $__env->make('partials/_head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
<?php $__env->startSection('body_content'); ?>
<?php echo $__env->yieldSection(); ?>
</body>
<?php echo $__env->make('partials/_javascript', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</html>