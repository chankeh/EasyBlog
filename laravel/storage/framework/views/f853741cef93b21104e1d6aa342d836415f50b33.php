<?php $__env->startSection('title', 'Tags #'.$tag->id.' '.$tag->name); ?>


<?php $__env->startSection('body_content'); ?>
    <div class="row">
        <div class="col-md-8">
            <h1><?php echo e($tag->name); ?> Tag <small><?php echo e($tag->posts()->count()); ?> Posts</small></h1>
        </div>
        <div class="col-md-2">
            <a href="<?php echo e(route('tags.edit', ['id' => $tag->id])); ?>" class="btn btn-primary btn-block pull-right" style="margin-top: 20px;">Edit</a>
        </div>
        <div class="col-md-2">
            <form action="<?php echo e(route('tags.destroy', ['id'=> $tag->id])); ?>" method="POST">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" value='Delete' class="btn btn-danger" style="width:100%;margin-top: 20px;">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <!-- tr: table row-->
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Tags</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($tag->posts as $post): ?>
                        <tr>
                            <th><?php echo e($post->id); ?></th>
                            <td><?php echo e($post->title); ?></td>
                            <td>
                                <?php foreach($post->tags as $postTag): ?>
                                    <span class="label label-default"><?php echo e($postTag->name); ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td><a href="<?php echo e(route('posts.show', ['id' => $post->id])); ?>" class="btn btn-default btn-xs">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>