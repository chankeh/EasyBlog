<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Tag;
use Purifier;
use Image;
use File;



class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // middleware opposite: auth  vs.  guest($this->guestMiddleware())
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //pass the data
        $loggedInUserId = Auth::id();
        $posts = Post::where('user_id', '=', $loggedInUserId)->get();  // 等价于Post::all()->where('user_id', $loggedInUserId);
                                                                       // 注意\Illuminate\Support\Collection类的构造函数中的getArrayableItems()函数
        return view('adminPanel/home', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // grab all categories from database for select
        $categories = Category::all();
        $tags = Tag::all();

        return view('adminPanel/createPost', ['categories' => $categories])->with('tags', $tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //var_dump($request);
        //print_r($request);
        //dd($request); // die dump          very useful!

        //validate the data
        // App\Http\Controllers\Controller类有一个trait：ValidatesRequests，里面有一个方法：validate()
        // and we should not rely on the javascript validation, only use client side validation to
        // improve the customer experience.
        $this->validate($request, [
            'title'           => 'required|max:255',
            'slug'            => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            'category_id'     => 'required|integer',
            'body'            => 'required',
            'featured_image'  => 'sometimes|image',  // sometimes: when that field is present in $request array.
        ]);


        //store in the database
        $post = new Post;
        $postUserId = Auth::id();
        // echo $request->title;
        // echo $request->body;
        $post->user_id = $postUserId;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = $request->body;
        // save our featured image

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);
            $post->featured_image = $filename;
        }


        $post->save();

        // associate the post with tags
        if (isset($request->tags))
            $post->tags()->sync($request->tags, false);  // attach是单个，sync是多个，第二个参数标识是否覆盖，false为不覆盖。override：remove and add。
        else
            $post->tags()->sync(array()); //

        //pass a successful message to the user
        Session::flash('success', 'The blog post was successfully save!'); // Session::put is a permanent method.

        //redirect to another page
        return redirect()->route('posts.show', ['id' => $post->id]);  //没必要在控制器方法中再跳转到方法 错误！有必要
        //请看update方法体中最后注释部分
        //return view('adminPanel/show')->with('post', $post);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        return view('adminPanel/show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::find($id);
        // grab all categories from database for select
        $categories = Category::all();
        $tags = Tag::all();
        $tagsForThisPost = json_encode($post->tags->pluck('id'));

        return view('adminPanel/editPost', ['post' => $post, 'categories' => $categories, 'tags' => $tags, 'tagsForThisPost' => $tagsForThisPost]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the data
        $this->validate($request, [
            'title'           => 'required|max:255',
            //'slug'          => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            //'slug'          => 'required|alpha_dash|max:255|unique:posts,slug,' . $id . 'id',
            'slug'            => "required|alpha_dash|max:255|unique:posts,slug,$id,id",
            'category_id'     => 'required|integer',
            'body'            => 'required',
            'featured_image'  => 'sometimes|image',
        ]);


        // Save the data to the database
        $post = Post::find($id);

        //编辑博文
        if (isset($request->title))
            $post->title = $request->input("title");
        if (isset($request->slug))
            $post->slug = $request->input("slug");
        if (isset($request->category_id))
            $post->category_id = $request->input("category_id");
        if (isset($request->body))
            $post->body = $request->input("body");
        if ($request->hasFile('featured_image')) {
            // Add the new image
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);

            // Update the database
            $oldFilename = $post->featured_image;
            $post->featured_image = $filename;

            // Delete the old image
            File::delete(public_path('images/'.$oldFilename));   // Storage::delete($oldFilename);  这种需要修改config/filesystems.php文件
        }



        $post->save();

        // associate the post with tags
        if (isset($request->tags))
            $post->tags()->sync($request->tags, true);  // attach是单个，sync是多个，第二个参数标识是否覆盖，true为覆盖。override：remove and add。
        else
            $post->tags()->sync(array()); //

        // Set flash data with success message
        Session::flash('success', 'The blog post was successfully saved!');



        // Redirect with flash data to posts.show
        //编辑博文
        if ('editPost' == $request->editPost){
            return redirect()->route('posts.show', ['idd' => $post->id]); //与下句代码的区别在于刷新时，下面的代码重新提交，而该句代码则已经跳转到了posts.show页面；
            //另外，传送的实参可以不叫id，因为这个实参构成了URL，而在控制器中的参数会把URL中的参数转换成id。
            //return view('adminPanel/show')->with('post', $post);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);

        $post->tags()->detach(); // it delete any reference to the post.

        File::delete(public_path('images/'. $post->featured_image));

        Post::destroy($id);


        Session::flash('success', 'The blog post has been deleted!');

        return redirect()->route('posts.index'); //综合store、update方法，有些时候还是不要直接return view的好，特别考虑重复提交产生的后果。
    }
}
