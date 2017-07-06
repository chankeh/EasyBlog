<?php $__env->startSection('title', '| View Post'); ?>

<?php $__env->startSection('body_content'); ?>
    <div class="container">
        <?php echo $__env->make('partials._adminPanelOperSuccessErrors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="row">
            <div class="col-md-8">
                <?php if(isset($post->featured_image)): ?>
                    <img src="<?php echo e(URL::asset('images/' . $post->featured_image)); ?>" alt="" width="800px" height="400px">
                <?php endif; ?>

                <h1 style="word-break:break-all;word-wrap:break-word;"><?php echo e($post->title); ?></h1>
                <p class="lead" style="word-break:break-all;word-wrap:break-word;"><?php echo $post->body; ?></p>

                <hr>

                <div class="tags">
                    标签：
                    <?php foreach($post->tags as $tag): ?>
                        <span class="label label-default"><?php echo e($tag->name); ?></span>
                    <?php endforeach; ?>
                </div>

                <!-- 后台评论显示 -->
                <div id="backend-comments" style="margin-top: 50px;">
                    <h3>Comments <small><?php echo e($post->comments->count()); ?> total</small></h3>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Comment</th>
                            <th width="70px"></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach($post->comments as $comment): ?>
                            <tr>
                                <td><?php echo e($comment->name); ?></td>
                                <td><?php echo e($comment->email); ?></td>
                                <td><?php echo e($comment->comment); ?></td>
                                <td>
                                    <a href="<?php echo e(route('comments.edit', $comment->id)); ?>" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a href="<?php echo e(route('comments.delete', $comment->id)); ?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- end of 后台评论显示 -->

            </div>

            <!-- sidebar room -->
            <div class="col-md-4">
                <div class="well">
                    <!-- definition list title description-->
                    <dl class="dl-horizontal">
                        <dt>Url:</dt>
                        <dd><a href="<?php echo e(url('blog/' . $post->slug)); ?>"> <?php echo e($post->slug); ?> </a></dd>
                    </dl>

                    <dl class="dl-horizontal">
                        <dt>Category:</dt>
                        <dd><?php echo e($post->category_id ? $post->category->name : 'Null'); ?></dd>
                    </dl>

                    <dl class="dl-horizontal">
                        <dt>Created At:</dt>
                        <dd><?php echo e($post->created_at); ?></dd>
                    </dl>

                    <dl class="dl-horizontal">
                        <dt>Updated At:</dt>
                        <dd><?php echo e(date('M j, Y h:iA', strtotime($post->updated_at))); ?></dd>
                    </dl>

                    <hr/>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="<?php echo e(route('posts.edit', ['id' => $post->id])); ?>" class="btn btn-primary btn-block">Edit</a>
                        </div>
                        <div class="col-sm-6">
                            <form action="<?php echo e(route('posts.destroy', ['id'=> $post->id])); ?>" method="POST" class="pull-right" style="width:100%;">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="_method" value="DELETE">
                                <input type="submit" value='Delete' class="btn btn-danger" style="width:100%;">
                            </form>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 12px;">
                        <div class="col-sm-12">
                            <a href="<?php echo e(route('posts.index')); ?>" class="btn btn-default btn-block">&lt;&lt; See All Posts</a>
                        </div>
                    </div>
                </div>
            </div> <!-- end of sidebar room-->
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>