<?php $__env->startSection('title', '| All Categories'); ?>


<?php $__env->startSection('body_content'); ?>

    <?php echo $__env->make('partials/_adminPanelOperSuccessErrors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="row">
        <div class="col-md-8">
            <h1>Categories</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($categories as $category): ?>
                        <tr>
                            <th><?php echo e($category->id); ?></th>
                            <td><?php echo e($category->name); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> <!-- end of .col-md-8 -->

        <div class="col-md-4">
            <div class="well">
                <h2>New Category</h2>

                <form action="<?php echo e(route('categories.store')); ?>" method="post" data-parsley-validate>  <!-- 看action看method -->
                    <?php echo e(csrf_field()); ?>


                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input name="name" type="text" class="form-control" required maxlength='255'>
                    </div>

                    <button type="submit" class="btn btn-primary">Create New Category</button>

                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>