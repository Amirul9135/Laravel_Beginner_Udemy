<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;

class FollowController extends Controller
{
    public function createFollow(User $user)
    {
        if (auth()->user()->id === $user->id) {
            return back()->with('error', 'You are not allowed to follow your own account');
        }

        if (Follow::where([['user_id', '=', auth()->user()->id], ['followed_user', '=', $user->id]])->count() > 0) {
            return back()->with('info', 'You are already following this user');
        }
        $follow = new Follow;
        $follow->user_id = auth()->user()->id;
        $follow->followed_user = $user->id;
        $follow->save();

        return back()->with('success', 'successfully followed '.$user->username);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function unfollow(User $user)
    {
        Follow::where([['user_id', '=', auth()->user()->id], ['followed_user', '=', $user->id]])->delete();

        return back()->with('success', 'successfully unfollowed '.$user->username);
    }
}
