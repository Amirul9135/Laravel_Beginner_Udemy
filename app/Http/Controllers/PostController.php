<?php

namespace App\Http\Controllers;

use App\Jobs\SendNewPostEmail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Post::class, 'post'); //2nd param need to match with variable name in the controller methods parameter, post here, then the Post object in the controller methods param must also be "post"
    }

    public function search($term)
    {
        $result = Post::search($term)->get();
        $result->load('postedBy:id,username,avatar'); //name of the function which returns the linking relation

        return $result;
    }

    /*
    * HTTP: POST
    */
    public function index()
    {
        // Your code to fetch and return all users
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Your code to show the form for creating a new user
        return view('create-post');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // Your code to show the form for editing a specific user
        return view('edit-post', ['post' => $post]);
    }

    /**
     * HTTP: POST
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $data['title'] = strip_tags($data['title']);
        $data['body'] = strip_tags($data['body']);
        $data['user_id'] = auth()->id();
        Post::create($data);

        dispatch(new SendNewPostEmail([auth()->user()->email], 'Post Created', 'You have succesfully created new post with title '.$data['title']));
        Log::info('posted');

        // Your code to validate and store a new user
        //return redirect('aprofile/'.auth()->user()->username.'/posts')->with('success', 'Posted Successfully');
        return redirect()->route('profile', ['user:username' => auth()->user()->username]);
    }

    /**
     * HTTP: GET
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        $post['body'] = Str::markdown($post->body);

        return view('single-post', ['post' => $post]);

    }

    /**
     * HTTP: PUT | PATCH
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // Your code to validate and update a specific user
        $data = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $post->update($data);

        return back()->with('info', 'Post Edited');
    }

    /**
     * HTTP: DELETE
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Your code to delete a specific user
        $post->delete();

        return redirect('profile/'.auth()->user()->username.'/posts');
    }
}
