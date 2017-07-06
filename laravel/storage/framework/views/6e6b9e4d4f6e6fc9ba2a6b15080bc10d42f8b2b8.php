<?php $__env->startSection('title', 'Edit #'.$comment->id.' Comment'); ?>

<?php $__env->startSection('body_content'); ?>
    <h1>Edit #<?php echo e($comment->id); ?> Comment</h1>
    <form action="<?php echo e(route('comments.update', ['id' => $comment->id])); ?>" method="post" data-parsley-validate>
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="_method" value="PUT" />

        <div class="form-group">
            <label for="name">Name:</label>
            <input name="name" type="text" class="form-control" value="<?php echo e($comment->name); ?>" disabled>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input name="email" type="text" class="form-control" value="<?php echo e($comment->email); ?>" disabled>
        </div>

        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea name="comment" id="" cols="30" rows="10" class="form-control"><?php echo e($comment->comment); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Comment</button>
        <a href="<?php echo e(route('posts.show', ['id' => $comment->post->id])); ?>" class="btn btn-default pull-right">Go Back</a>

    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>