<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //Blog's Home for public reader
    /*
    Route::get('/', function () {
        return view('blog/home');
    });
    */
    ////主页
    Route::get('/', ['uses' => 'HomeController@homePage', 'as' => 'homePage']); //路由名称为homePage
    //Route::get('/', 'HomeController@homePage')->name('homePage'); //增加路由名称为homePage
    //Route::post('/logout', '\App\Http\Controllers\Auth\AuthController@logout'); // Logout FORM METHOD='POST'
    ////关于我
    Route::get('/aboutMe', 'HomeController@getAboutMe');
    ////联系我  省略
    Route::get('/contact', 'HomeController@getContact');
    Route::post('/contact', 'HomeController@postContact');


    //博客页
    Route::get('/blog', ['uses' => 'BlogController@getIndex', 'as' => 'blog.index']); //archive page
    //通过ID号来访问博客
    //Route::get('/viewBlog/{id}', ['uses' => 'BlogController@getView',  'as' => 'blog.view']); //路由名称为blog.view，表示单个博客(博文)相关的路由，操作。PS:博客，又名网络日志。
    //Route::put('/viewBlog/{id}', ['uses' => 'BlogController@putUpdate',  'as' => 'blog.update']); //更新评论数、访问数
    //通过可读性更好的Title的Slug来访问博客
    Route::get('/blog/{slug}', ['uses' => 'BlogController@getSingle', 'as' => 'blog.single']);//single page,比上面的more human readable!
        //->where('slug', '[\w\d\-\_]+'); twitter:@[\w\d\-\_]+
    Route::put('/blog/{slug}', ['uses' => 'BlogController@putUpdate',  'as' => 'blog.update']); //更新评论数、访问数
    //评论



    //Blog后台管理
    Route::resource('posts', 'PostController');

    ////Categories(类别)
    Route::resource('categories', 'CategoryController', ['except' => ['create']]);

    ////Tags(标签)
    Route::resource('tags', 'TagController');


    ////Comments(评论)
    //Route::resource('comments', 'CommentController', ['except' => ['create']]); //是用户评论的，你怎么可能自己增加评论。
    Route::post('comments/{post_id}', ['uses' => 'CommentController@store', 'as' => 'comments.store']);
    //后台编辑评论
    Route::get('comments/{id}/edit', ['uses' => 'CommentController@edit', 'as' => 'comments.edit']);
    Route::put('comments/{id}', ['uses' => 'CommentController@update', 'as' => 'comments.update']);
    //后台删除评论
    Route::get('comments/{id}/delete', ['uses' => 'CommentController@delete', 'as' => 'comments.delete']);
    Route::delete('comments/{id}', ['uses' => 'CommentController@destroy', 'as' => 'comments.destroy']);

});



Route::group(['middleware' => 'web'], function () {
    // Authentication Routes
    /* 手动添加如下，自动添加为：Route::auth();
     * //Login Routes
     * Route::get('/auth/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin']);  //Show the Login Form
     * Route::post('/auth/login', 'Auth\AuthController@postLogin'); //Post the Login User's Data   注意理解上一条和这一条
     * Route::get('/auth/logout', 'Auth\AuthController@getLogout');
     * //Registration Routes
     * Route::get('/auth/register', 'Auth\AuthController@getRegister'); //getRegister => getRegisterForm 手写认证，如果利用AuthController控制器继承自AuthenticatesAndRegistersUsers trait的方法，名字不能改。
     * Route::post('/auth/register', 'Auth\AuthController@postRegister'); //postRegister => postRegisterData  注意理解上一条和这一条
     */
    //Route::auth();

    //注册
    //Route::get('register','Auth\AuthController@showRegistrationForm');
    //Route::post('register','Auth\AuthController@register');
    //登录
    Route::get('login','Auth\AuthController@showLoginForm');
    Route::post('login','Auth\AuthController@login');
    //登出
    Route::get('logout','Auth\AuthController@logout');


    Route::get('/home', 'HomeController@index');  //默认的Laravel页面
});
