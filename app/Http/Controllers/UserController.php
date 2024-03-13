<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class UserController extends Controller
{
    public function userFollowers(User $user)
    {

        $this->profileSharedData($user);

        return view('profile-followers', ['followers' => $user->followers()->get()]);
    }

    public function userFollowings(User $user)
    {

        $this->profileSharedData($user);

        return view('profile-followings', ['followings' => $user->followings()->get()]);
    }

    public function userPosts(User $user) //variable naming has to be same as what declared as path var in routing
    {
        $this->profileSharedData($user);

        return view('profile-posts', ['posts' => $user->posts()->get()]);
    }

    private function profileSharedData(User $user)
    {
        if (! auth()) {
            return false;
        }
        view()->share('profileData', ['followingsCount' => $user->followings()->count(), 'followersCount' => $user->followers()->count(), 'postCount' => $user->posts()->count(), 'isFollowing' => Follow::where([['user_id', '=', auth()->user()->id], ['followed_user', '=', $user->id]])->count() > 0, 'user' => $user]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:3000', //max is in kB
        ]);

        $manager = new ImageManager(new Driver());
        $rawimage = $manager->read($request->file('avatar'));
        $image = $rawimage->cover(120, 120)->toJpeg();
        /** @var \App\Models\User $user * */
        $user = auth()->user();

        $filename = $user->id.'-'.uniqid().'.jpg';

        Storage::put('public/avatars/'.$filename, $image);

        $old = $user->avatar; //this 1 GET used the getter method which alrdy includes path
        $user->avatar = $filename; //this 1 the exact filename
        $user->save();

        if ($old != '/default-avatar.jpg') {
            Storage::delete(str_replace('/storage/', 'public/', $old)); //hence here need to partially remove the path in old
        }

        return back()->with('info', 'Avatar Changed Successfully');
    }

    public function manageAvatar(User $user)
    {
        return view('manage-avatar', ['user' => $user]);
    }

    public function showCorrectHomepage()
    {
        if (auth()->check()) {
            /** @var \App\Models\User $user * */
            $user = auth()->user();

            return view('homepage-feed', ['feeds' => $user->feedPosts()->paginate(5)]);
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

            return redirect('/')->with('info', 'Welcome');

        } else {

            return redirect('/')->with('error', 'Invalid Login, Please Try Again');
        }

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

        if (auth()->attempt($data)) {
            $request->session()->regenerate();

        }

        // Your code to validate and store a new user
        return redirect('/');
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
