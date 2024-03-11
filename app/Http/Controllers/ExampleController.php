<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    public function homepage()
    {
        $data = 'something';
        $somearray = ['first elem', 'second', 'third'];

        return view('homepage', ['arr' => $somearray, 'data' => $data]);
    }

    public function singlePost()
    {
        return view('single-post');
    }
}
