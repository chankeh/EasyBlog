<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Post;

//博客标题不一定唯一
//Slug唯一，因为它要标识唯一的URL
//比如标题：山东高考成绩出炉

class BlogController extends Controller
{
    public function getIndex()
    {
        $posts = Post::paginate(2);

        return view('blog/index')->with('posts', $posts);
    }

    //由于跨域无法正常ajax
    public function getView($id)
    {
        $post = Post::find($id);
        return view('blog/viewBlog', ['id' => $id, 'post' => $post]);
    }

    //更新访问数
    public function putUpdate(Request $request, $slug)
    {
        $post = Post::where('slug', '=', $slug)->first(); //其实应该就只有一个

        //更新访问数
        if (isset($request->visitCount))
            $post->visit_count = $request->visitCount;
        $post->save();

        //return redirect()->route('blog.single', ['slug' => $post->slug]); //防止重复转到页面增加浏览数
    }

    public function getSingle($slug)
    {
        //$title = str_replace('-', ' ', $slug);
        //MySQL to convert a string into a slug
        //LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM('My String'), ':', ''), ')', ''), '(', ''), ',', ''), '\\', ''), '\/', ''), '\"', ''), '?', ''), '\'', ''), '&', ''), '!', ''), '.', ''), ' ', '-'), '--', '-'), '--', '-')) AS `post_name`

        $post = Post::where('slug', '=', $slug)->get()->first(); //其实应该就只有一个
        return view('blog/viewBlog', ['id' => $post->id, 'post' => $post]);
    }


}