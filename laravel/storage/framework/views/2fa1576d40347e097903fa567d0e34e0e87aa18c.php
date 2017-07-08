<?php $__env->startSection('stylesheets'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('css/comment.css')); ?>">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('title', "View Blog #$id"); ?>

<?php $__env->startSection('content'); ?>


    <!-- 更新浏览数 -->
    <form style=""  id="fbCommentCountForm" action="<?php echo e(route('blog.update', ['id'=> $id])); ?>" method="POST" style="display: none;">
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="_method" value="PUT">
        <input type="text" name="visitCount" id="fbFormVisitCount" value="<?php echo e($post->visit_count); ?>" style="display: none;">
        <input type="submit" name="sbm" value="submit comment count" style="display: none;">
    </form>


    <div id="postContent" class="row">

        <!-- 博客显示 -->
        <div class="col-md-8 col-md-offset-2" style="margin-top: 50px;">
            <?php if(!is_null($post->featured_image)): ?>
                <img src="<?php echo e(URL::asset('images/' . $post->featured_image)); ?>" alt="" width="800px" height="400px">
            <?php endif; ?>
            <h1><?php echo e($post->title); ?></h1> <!-- 注意这两个的区别，原样输出 -->
            <small><?php echo e(date('Y-n-j G:i', strtotime($post->created_at))); ?>&nbsp;&nbsp;浏览:<?php echo e($post->visit_count); ?>次&nbsp;&nbsp;评论:<?php echo e($post->comments->count()); ?>次</small>
            <br>
            <br>
            <p><?php echo $post->body; ?></p> <!-- 注意这两个的区别 -->
            <br>
            <br>
            <p>发布于：<?php echo e($post->category->name); ?></p>
            <div class="tags">
                标签：
                <?php foreach($post->tags as $tag): ?>
                    <span class="label label-default"><?php echo e($tag->name); ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 评论显示 -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2" style="margin-top: 50px;">
                <h3 class="comment-title"><span class="glyphicon glyphicon-comment"></span>&nbsp;<?php echo e($post->comments->count()); ?>&nbsp;评论</h3>
                <?php foreach($post->comments as $comment): ?>
                    <div class="comment">
                        <div class="author-info">
                            <img src="<?php echo e("https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))) . "?s=50&d=monsterid"); ?>" alt="" class="author-image">
                            <div class="author-name">
                                <h4><?php echo e($comment->name); ?></h4>
                                <p><?php echo e(date('F nS, Y-g:iA', strtotime($comment->created_at))); ?>&nbsp;&nbsp;&nbsp;<?php echo e($comment->updated_at->diffForHumans()); ?></p>
                            </div>
                        </div>
                        <div class="comment-content">
                            <?php echo e($comment->comment); ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 评论框 -->
        <div class="row">
            <div id="comment-form" class="col-md-8 col-md-offset-2" style="margin-top: 50px;">
                <form action="<?php echo e(route('comments.store', ['id' => $post->id])); ?>" method="post">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">姓名:</label>
                            <input name="name" type="text" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email">邮箱:</label>
                            <input name="email" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="comment">内容:</label>
                            <textarea name="comment" id="" cols="15" rows="5" class="form-control"></textarea>
                            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 15px;">添加评论</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

    <script>

        //ajax更新浏览数
        setTimeout(function() {
            //更新浏览数，+1。
            var visitCount = document.getElementById('fbFormVisitCount').value;
            //等价于 var visitCount = document.getElementById('fbFormVisitCount').attributes['value'].nodeValue;
            document.getElementById('fbFormVisitCount').value = (parseInt(visitCount)+1).toString();

            var $formVar = $('form');

            $.ajax({
                url: $formVar.prop('<?php echo e(route('blog.update', ['slug' => $post->slug])); ?>'),
                method: 'PUT',
                data: $formVar.serialize()
            });
        }, 5000); //延迟等待5秒

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.blogTemplate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>