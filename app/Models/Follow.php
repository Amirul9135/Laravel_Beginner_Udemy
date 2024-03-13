<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public function followingUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function followedUser() //name xle contradict dengan nama attribute
    {
        return $this->belongsTo(User::class, 'followed_user');

    }
}
