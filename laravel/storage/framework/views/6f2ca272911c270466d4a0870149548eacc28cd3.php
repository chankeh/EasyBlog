<?php $__env->startSection('title', '| Edit Tag #'.$tag->id.' '.$tag->name); ?>


<?php $__env->startSection('body_content'); ?>
    <form action="<?php echo e(route('tags.update', ['id' => $tag->id])); ?>" method="post" data-parsley-validate>
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="_method" value="PUT" />

        <div class="form-group">
            <label for="name">Name:</label>
            <input name="name" type="text" class="form-control" value="<?php echo e($tag->name); ?>" required maxlength='255'>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>