<style type="text/css">
    ul.blue {
        padding: 5px;
        margin: 14px 0;
        list-style: none;
        background-color: #fff;
        /*border-bottom: 1px solid #e7e7e7; */
        float: right;
    }

    ul.blue li {
        float: left;
        display: inline; /*For ignore double margin in IE6*/
        margin: 0 10px;
    }

    ul.blue li a {
        text-decoration: none;
        float:left;
        color: #999;
        cursor: pointer;
        /*font: 900 14px/22px "Arial", Helvetica, sans-serif;*/
    }

    ul.blue li a span {
        margin: 0 10px 0 -10px;
        padding: 1px 8px 5px 18px;
        position: relative; /*To fix IE6 problem (not displaying)*/
        float:left;
    }
    /*BLUE*/
    ul.blue li a.current, ul.blue li a:hover {
        background: url("<?php echo e((0 == ($rand = mt_rand(0, 2))) ? URL::asset('banner/blue.png') : ($rand == 1 ? URL::asset('banner/green.png') : URL::asset('banner/pink.png'))); ?>") no-repeat top right;
        color: #0d5f83;
    }

    ul.blue li a.current span, ul.blue li a:hover span {
        background: url("<?php echo e((0 == $rand) ? URL::asset('banner/blue.png') : ($rand == 1 ? URL::asset('banner/green.png') : URL::asset('banner/pink.png'))); ?>") no-repeat top left;
    }
</style>


    <ul class="blue">
        <li><a href="http://127.0.0.1/laravel/public/index.php" class="<?php echo e(Request::is('/') ? 'current' : ''); ?>"><span>主页</span></a></li>
        <li><a href="http://127.0.0.1/laravel/public/index.php/blog" class="<?php echo e(Request::url() ==  "http://127.0.0.1/laravel/public/index.php/blog" ? 'current' : ''); ?>"><span>博客</span></a></li>
        <li><a href="http://127.0.0.1/laravel/public/index.php/aboutMe" class="<?php echo e(strpos(Request::url(), '/aboutMe') != FALSE ? 'current' : ''); ?>"><span>关于</span></a></li>
    </ul>