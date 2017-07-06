<?php $__env->startSection('title', 'View Post #' . $id); ?>

<?php $__env->startSection('content'); ?>

    <?php /* facebook comments system sdk script */ ?>
    <div id="fb-root"></div>


    <?php /* disqus comments system to load  step.1 */ ?>
    <div id="disqus_thread"></div>



    <button onclick="countComment()">Alert Facebook Comment Count</button>
    <div>
        <span class="fb-comments-count" id="fbCommentCount" data-href="<?php echo e(Request::url()); ?>"></span>
    </div>

    <!-- 更新评论数，浏览数 -->
    <form style=""  id="fbCommentCountForm" action="<?php echo e(route('updatePost', ['id'=> $id])); ?>" method="POST">
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="_method" value="PUT">

        <input type="text" name="commentCount" id="fbFormCommentCount">
        <input type="text" name="visitCount" id="fbFormVisitCount" value="<?php echo e($post->visit_count); ?>">
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
                                                   <!-- 这样也可以data-href="http://127.0.0.1/laravel/public/index.php/posts/$id }}" -->
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <?php /* facebook comments system sdk script */ ?>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/zh_CN/sdk.js#xfbml=1&version=v2.8";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <?php /* disqus comments system to load   step.2 */ ?>
    <?php /* IMPORTANT: Replace EXAMPLE with your forum shortname! --> */ ?>
    <script>

        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
        /*
         var disqus_config = function () {
         this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
         this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
         };
         */
        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://xiaopo-me.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <script id="dsq-count-scr" src="//xiaopo-me.disqus.com/count.js" async></script>


    <script>

        /*
         $(document).ready(function() {



         });
         */

        /* 这种写法错误!
         $(window).load(function () {
         console.log('2');
         });
         */
        //$(window).on("load", function (e) {alert(2);}); // 这种写法正确!


        var fbCommentCount = document.getElementById('fbCommentCount').getElementsByClassName('fb_comments_count');
        function countComment() {
            alert(fbCommentCount[0].innerHTML);
        }

        //ajax更新评论数，浏览数
        setTimeout(function() {
            //更新评论数。
            document.getElementById('fbFormCommentCount').value = fbCommentCount[0].innerHTML; //要花时间等待变换成<span>3</span>，否则<span></span>取不出来。
            //更新浏览数，+1。
            var visitCount = document.getElementById('fbFormVisitCount').value;
            //等价于 var visitCount = document.getElementById('fbFormVisitCount').attributes['value'].nodeValue;
            document.getElementById('fbFormVisitCount').value = (parseInt(visitCount)+1).toString();

            var $formVar = $('form');

            $.ajax({
                url: $formVar.prop('<?php echo e(route('updatePost', ['id' => $id])); ?>'),
                method: 'PUT',
                data: $formVar.serialize()
                /*
                 headers: {
                 "Content-Type": "application/json",
                 "X-HTTP-Method-Override": "PUT" ,
                 },
                 */
            });
        }, 5000); //所花时间为5秒

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.blogTemplate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>