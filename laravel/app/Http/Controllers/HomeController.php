<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Request as RequestFacade; //嘿嘿 by xiaopo
use App\Post;
use Mail;
use Session;

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
                $posts = Post::orderBy('created_at', 'desc')->paginate(10);
                break;
            case 'Commented':
                $posts = Post::orderBy('comment_count', 'desc')->paginate(10);
                break;
            case 'Visited':
                $posts = Post::orderBy('visit_count', 'desc')->paginate(10);
                break;
            default:
                $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        }

        $data = array(
            'posts' => $posts,
            'orderBy' => RequestFacade::input('orderBy'),
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
