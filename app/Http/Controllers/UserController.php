<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function userPosts(User $user) //username naming has to be same as what declared as path var in routing
    {
        return view('profile-posts', ['user' => $user, 'posts' => $user->posts()->get()]);
    }

    public function showCorrectHomepage()
    {
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'loginusername' => ['required'],
            'loginpassword' => ['required'],
        ]);

        if (auth()->attempt(['username' => $data['loginusername'], 'password' => $data['loginpassword']])) {
            $request->session()->regenerate();

        } else {
        }

        return redirect('/');
    }

    /*
    * HTTP: POST
    */
    public function index()
    {
        // Your code to fetch and return all users
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
            'username' => ['required', 'min:3', 'max:20',  Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],

            'password' => ['required', 'min:8',  'confirmed'],
        ]);
        User::create($data);

        // Your code to validate and store a new user
        return 'sini la patot';
    }

    /**
     * HTTP: GET
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Your code to fetch and return a specific user
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Your code to delete a specific user
    }
}
