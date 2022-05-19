<?php

namespace App\Http\Controllers;

class DislikeController extends Controller
{
    public function store($likeable_type, $likeable_id)
    {
        $likeable_id->dislikedBy(auth()->user());
        
        return back();
    }
}
