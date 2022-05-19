<?php

namespace App\Http\Controllers;

class LikeController extends Controller
{
    public function store($likeable_type, $likeable_id)
    {
        $likeable_id->likedBy(auth()->user());

        return back();
    }
}
