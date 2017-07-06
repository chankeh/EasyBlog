<?php $__env->startSection('title', 'View Post #' . $id); ?>

<?php $__env->startSection('content'); ?>
    <button onclick="countComment()">Alert Facebook Comment Count</button>
    <div id="fbCommentCount">
        <span class="fb-comments-count" data-href="<?php echo e(Request::url()); ?>"></span>
    </div>

    <!-- 更新评论数 -->
    <form style=""  id="fbCommentCountForm" action="<?php echo e(route('posts.update', ['id'=> $id])); ?>" method="POST">
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="_method" value="PUT">

        <input type="text" name="commentCount" id="fbFormCommentCount">
        <input type="submit" name="sbm" value="submit comment count">
    </form>

    <div class="row">
        <a href="http://127.0.0.1/laravel/public/index.php">Go to Home</a>
    </div>
    <div id="postContent" class="row">
        <h1><?php echo e($post->title); ?></h1>
        <p><?php echo e($post->body); ?></p>
    </div>

    <!-- facebook comment system show comment -->
    <div class="row text-center" id="facebookCommentContainer">
        <div class="fb-comments" data-href="<?php echo e(Request::url()); ?>" data-width="800" data-numposts="10"></div>  <!-- 宽度800 每页10个评论 -->
                                                   <!-- 这样也可以data-href="http://127.0.0.1/laravel/public/index.php/posts/<?php echo e($id); ?>" -->
    </div>


    <script>
        var fbCommentCount = document.getElementById('fbCommentCount').getElementsByClassName('fb_comments_count');
        function countComment() {
            alert(fbCommentCount[0].innerHTML);
        }

        //ajax更新评论数
        setTimeout(function() {
            document.getElementById('fbFormCommentCount').value = fbCommentCount[0].innerHTML;

            var $formVar = $('form');

            $.ajax({
                url: $formVar.prop('<?php echo e(route('posts.update', ['id'=> $id])); ?>'),
                method: 'PUT',
                data: $formVar.serialize()
            });
        }, 10000);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.viewPostTemplate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>