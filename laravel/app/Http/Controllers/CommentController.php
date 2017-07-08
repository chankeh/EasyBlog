<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use App\Comment;
use Session;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        //
        $this->validate($request, array(
            'name'      =>  'required|max:255',
            'email'     =>  'required|email|max:255',
            'comment'   =>  'required|min:5|max:2000'
        ));

        $post = Post::find($post_id);
        $comment = new Comment();
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->approved = true;
        $comment->post()->associate($post); // not attach, hiahia    $comment->post_id = $post_id;
        $comment->save();

        //更新博客评论数
        $post = Post::find($post_id);
        $post->comment_count =  $post->comment_count + 1;
        $post->save();

        Session::flash('success', 'Comment was added');

        return redirect()->route('blog.single', ['slug' => $post->slug]);
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
        $comment = Comment::find($id);

        return view('comments/edit', ['comment' => $comment]);
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
        //
        $this->validate($request, array(
            'comment'   =>  'required|min:5|max:2000'
        ));

        $comment = Comment::find($id);
        $comment->comment = $request->comment;
        $comment->save();

        Session::flash('success', 'Comment was successfully updated!');

        return redirect()->route('posts.show', ['slug' => $comment->post->id]);
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        return view('comments/delete')->with('comment', $comment);
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
        $comment = Comment::find($id);
        $post_id = $comment->post->id;
        $comment->delete();

        Session::flash('success', 'Comment has been deleted!');

        return redirect()->route('posts.show', ['id' => $post_id]);

    }
}
