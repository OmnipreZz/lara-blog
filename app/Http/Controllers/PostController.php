<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Tag;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        // $posts = DB::table('posts')
        // ->orderBy('id', 'desc')
        // ->get();
        $tags = \App\Tag::pluck('name','id');

        $posts = Post::with('tags')->orderBy('id', 'desc')->get();
        return view('pages.index', ['posts' => $posts,'tags'=>$tags]);
    }

    /**
     * Display a listing of the resource after research by tag
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $tags = \App\Tag::pluck('name','id');

        $allposts = Post::with('tags')->get();

        $posts = [];

        foreach($allposts as $post){
            if(in_array($request->tags, $post->getTagListAttribute()))
                array_push($posts, $post);
        }

        return view('pages.index', ['posts' => $posts,'tags'=>$tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = \App\Tag::pluck('name','id');
        return view('pages.postcreate',compact('tags'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->author = Auth::user()->name;
        $post->image = 'https://picsum.photos/200/300/?random';
        $post->user_id = Auth::user()->id;

        $post->save();
        //$post = Auth::user()->posts()->create($request->all());
        $post->tags()->attach($request->input('tags'));

        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $comments = DB::table('comments')
        ->where('post_id', '=', $id)
        ->orderBy('id', 'desc')
        ->get();
        return view('pages.postshow',['post'=>$post, 'comments'=>$comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tags = \App\Tag::pluck('name','id');

        $post = Post::find($id);
        $hisTags = $post->getTagListAttribute();

        return view('pages.postupdate',['post'=>$post,'tags'=>$tags,'hisTags'=>$hisTags]);
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
        $post = Post::find($id);

        $post->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        $this->syncTags($post, $request->input('tags', []));
        
        return $this->index();
    }

    private function syncTags(Post $post, $tags)
    {
      $post->tags()->sync(!$tags ? [] : $tags);
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
        DB::table('posts')
        ->where('id','=',$id)->delete();

        return $this->index();
    }
}
