@extends('layouts.template')

@section('stylesheets')
    <!-- 对比一下Html helper -->
    <!-- Html::style('css/parseley.css') }} -->
    <!--<link rel="stylesheet" href="../../../public/css/parsley.css"> -->
    <!--<link rel="stylesheet" href="../../../public/css/select2.min.css"> -->
    <!-- 用上面这个引入方式本页面(createPost)未出现BUG -->
    <link rel="stylesheet" href="{{ URL::asset('css/parsley.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/select2.min.css') }}">
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
@endsection

@section('title', 'Add New Blog Post')

@section('body_content')
    <div class="container">
        <h1>Add New Post</h1>
        <div class="col-md-8 col-md-offset-2">

            <!--

            对比一下Form helper
             Form::open(array('route' => 'posts.store', 'data-parsley-validate' => '')) !!}
                     Form::label('title', 'Title:') }}
                     Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}

                     Form::label('body', 'Body::') }}
                     Form::textarea('body', null, array('class' => 'form-control', 'required' => '')) }}

                     Form::submit('Submit', array('class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top: 20px;')) }}
            !! Form::close() !!}}


            -->
            <form action="{{ route('posts.store') }}" method="post"  enctype="multipart/form-data" data-parsley-validate>  <!-- 看action看method -->
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="title">Title:</label>
                    <input name="title" type="text" class="form-control" required maxlength='255'>
                </div>

                <div class="form-group">
                    <label for="slug">Slug:</label>
                    <input name="slug" type="text" class="form-control" required minlength="5" maxlength='255'>
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label for="tags">Tags</label>
                    <select class="form-control tags-class" id="tags" name="tags[]" multiple="multiple">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="featured_image">Upload Featured Image:</label>
                    <input type="file" name="featured_image" id="featured_image">
                </div>

                <div class="form-group">
                    <label for="body">Body:</label>
                    <textarea name="body" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('posts.index') }}" class="btn btn-default pull-right">Go Back</a>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- 对比一下Html helper -->
    <!-- Html::script('js/parsley.min.js') }}-->
    <!--<script language="JavaScript" src="../../../public/js/parsley.min.js"></script> -->
    <!--<script language="JavaScript" src="../../../public/js/select2.full.min.js"></script> -->
    <!-- 用上面这个引入方式本页面(createPost)未出现BUG -->
    <script type="text/javascript" src="{{ URL::asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $(".tags-class").select2();
    </script>
@endsection