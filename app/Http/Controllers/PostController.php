<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Post::class, 'post');
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
    public function edit($id)
    {
        // Your code to show the form for editing a specific user
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

        // Your code to validate and store a new user
        return 'post created';
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
    public function update(Request $request, $id)
    {
        // Your code to validate and update a specific user
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

        return 'this is delete';
    }
}
