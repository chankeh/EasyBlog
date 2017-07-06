<?php $__env->startSection('title', '| DELETE COMMENT?'); ?>

<?php $__env->startSection('body_content'); ?>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>DELETE THIS COMMENT?</h1>
            <p>
                <strong>Name:</strong> <?php echo e($comment->name); ?><br>
                <strong>Email:</strong> <?php echo e($comment->email); ?><br>
                <strong>Comment:</strong> <?php echo e($comment->comment); ?>

            </p>

            <form action="<?php echo e(route('comments.destroy', ['id' => $comment->id])); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" value="YES DELETE THIS COMMENT" class="btn btn-lg btn-block btn-danger">
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>