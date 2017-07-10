<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use Illuminate\Http\Request;

use Request as RequestFacade; //嘿嘿 by xiaopo
use App\Post;
use Mail;
use Session;
use App\Tag;

class HomeController extends Controller
{
    public static $orderBy; //使用类静态变量无法保存上一次的值，大概原因是每次路由的类都不一样。



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('home');

    }

    public function homePage()
    {
        //$posts = Post::all();
        //$posts = Post::paginate(10); //分页，10个数据为一页
        static $orderByInPublicHomePage; //这种方法也不行。
        switch(RequestFacade::input('orderBy')){
            case 'Recent':
                $posts = Post::orderBy('created_at', 'desc')->paginate(5);
                break;
            case 'Commented':
                $posts = Post::orderBy('comment_count', 'desc')->paginate(5);
                break;
            case 'Visited':
                $posts = Post::orderBy('visit_count', 'desc')->paginate(5);
                break;
            default:
                $posts = Post::orderBy('created_at', 'desc')->paginate(5);
        }


         if(null != ($categoryId = RequestFacade::input('categoryId'))) {
             //dd($category->posts()); //返回为null，因为在PostController中的store和update方法中都没有关联。
             $posts = Post::where('category_id', '=', $categoryId)->orderBy('created_at', 'desc')->paginate(5);
         }

        if(null != ($tagId = RequestFacade::input('tagId'))) {
            $tag = Tag::find($tagId);
            $posts = $tag->posts()->orderBy('created_at', 'desc')->paginate(5);
        }


        //获取所有目录，及目录下博客文章数
        $categories = Category::all();
        foreach ($categories as $category) {
            $category->count = Post::where('category_id', '=', $category->id)->count();
        }

        //获取所有标签
        $tags = Tag::all();

        //评论最多的前十篇博客文章
        $postCommented10  = Post::orderBy('comment_count', 'desc')->take(10)->get();


        $data = array(
            'posts'           => $posts,
            'orderBy'         => RequestFacade::input('orderBy'),
            'categoryId'      => RequestFacade::input('categoryId'),
            'tagId'           => RequestFacade::input('tagId'),

            'categories'      => $categories,
            'tags'            => $tags,
            'postCommented10' => $postCommented10,
        );
        return view('home/homePage', $data);
    }

    public function getAboutMe()
    {
        return view('home/aboutMe');
    }

    public function getContact()
    {
        return view('home/contact');
    }

    public function  postContact(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'subject' => 'min:3|max:100',
            'message' => 'min:10'
        ]);

        $data = array(
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message, // can not use Message because message has been used for something else.
        );
        Mail::send('emails.contact', $data, function ($message) use ($data) {
            //$message->from($data['email']);
            $message->to('gray_guest@126.com');
            $message->subject($data['subject']);
        });

        Session::flash('success', 'Your email has been sent!');

        return redirect('/contact');// return redirect()->url('/contact');

    }
}
