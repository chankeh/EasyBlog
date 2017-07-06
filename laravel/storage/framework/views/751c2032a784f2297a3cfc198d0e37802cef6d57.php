<?php $__env->startSection('stylesheets'); ?>
    <!-- 对比一下Html helper -->
    <!-- Html::style('css/parseley.css') }} -->
    <!--<link rel="stylesheet" href="../../../public/css/parsley.css"> -->
    <!--<link rel="stylesheet" href="../../../public/css/select2.min.css"> -->
    <!-- 用上面这个引入方式本页面（editPost）出现了BUG，两个public目录。 -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('css/parsley.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(URL::asset('css/select2.min.css')); ?>">
    <!-- tinyMCE编辑器安装 -->
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 500,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
            ],
            //menubar: false,
            /*menu: {
             view: {title: 'Edit', items: 'cut, copy, paste'}
             },*/
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
            image_advtab: true,
            templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', 'Edit #'.$post->id.' Post'); ?>

<?php $__env->startSection('body_content'); ?>
    <div class="container">
        <h1>Edit #<?php echo e($post->id); ?> Post</h1>
        <?php echo $__env->make('partials._adminPanelOperSuccessErrors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-md-8 col-md-offset-2">
            <form action="<?php echo e(route('posts.update', ['id' => $post->id])); ?>" method="post" enctype="multipart/form-data" data-parsley-validate>
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="_method" value="PUT" />

                <div class="form-group">
                    <label for="title">Title:</label>
                    <input name="title" type="text" class="form-control" value="<?php echo e($post->title); ?>" required maxlength='255'>
                </div>

                <div class="form-group">
                    <label for="slug">Slug:</label>
                    <input name="slug" type="text" class="form-control" value="<?php echo e($post->slug); ?>" required minlength="5" maxlength='255'>
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="category_id">
                        <?php foreach($categories as $category): ?>
                            <option <?php echo e($post->category_id == $category->id ? 'selected' : ''); ?> value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tags">Tags</label>
                    <select class="form-control tags-class" id="tags" name="tags[]" multiple="multiple">
                        <?php foreach($tags as $tag): ?>
                            <option <?php foreach ($post->tags as $postTag)  if ($postTag->id == $tag->id) { echo 'selected="selected"';break;} ?> value="<?php echo e($tag->id); ?>"><?php echo e($tag->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="featured_image">Update Featured Image:</label>
                    <input type="file" name="featured_image" id="featured_image">
                </div>

                <div class="form-group">
                    <label for="body">Body:</label>
                    <textarea name="body" id="" cols="30" rows="10" class="form-control"><?php echo e($post->body); ?></textarea>
                </div>

                <input type="hidden" name="editPost" value="editPost" />

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?php echo e(route('posts.index')); ?>" class="btn btn-default pull-right">Go Back</a>

            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <!-- 对比一下Html helper -->
    <!-- Html::script('js/parsley.min.js') }}-->
    <!--<script language="JavaScript" src="../../../public/js/parsley.min.js"></script> -->
    <!--<script language="JavaScript" src="../../../public/js/select2.full.min.js"></script> -->
    <!-- 用上面这个引入方式本页面（editPost）出现了BUG，两个public目录。 -->
    <script type="text/javascript" src="<?php echo e(URL::asset('js/parsley.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(URL::asset('js/select2.full.min.js')); ?>"></script>
    <script type="text/javascript">
        var tags = <?php echo e($tagsForThisPost); ?>


        $(".tags-class").select2();
        $(".tags-class").select2().val(tags).trigger('change'); // from: https://select2.github.io/examples.html#programmatic-control
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>