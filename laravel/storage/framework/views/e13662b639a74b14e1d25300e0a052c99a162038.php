<?php $__env->startSection('title', 'Blog Admin Panel'); ?>

<?php $__env->startSection('content'); ?>

    <div class="nav navbar-nav pull-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
            </a>

            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="<?php echo e(url('/logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="<?php echo e(url('/logout')); ?>" style="display: none;">  <!-- POST提交方式,后来发现没必要用POST啊 -->
                        <?php echo e(csrf_field()); ?>

                    </form>
                </li>
            </ul>
        </li>
    </div>

    <h1>Admin Panel</h1>

    <a href="<?php echo e(route('posts.create')); ?>" class="btn btn-primary pull-right">Add New Blog Post</a>

    <br><br><br>

    <table class="table">
        <thead>
        <th>id</th>
        <th>title</th>
        <th>body</th>
        <th>edit</th>
        <th>delete</th>
        </thead>

        <tbody>
        <?php foreach($posts as $post): ?>
            <tr>
                <th><?php echo e($post->id); ?></th>
                <td><?php echo e($post->title); ?></td>
                <td><?php echo e($post->body); ?></td>
                <td>edit button</td>
                <td>delete button</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>