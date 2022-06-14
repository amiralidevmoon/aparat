<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Category;
use App\Models\Video;
use App\services\VideoService;

class VideoController extends Controller
{
    public function index()
    {
        return Video::all();
    }

    public function create()
    {
        $categories = Category::all();

        return view('videos.create', compact('categories'));
    }

    public function store(StoreVideoRequest $request)
    {
        (new VideoService)->create($request->user(), $request->all());

        return to_route('index')->with('alert', __('messages.success'));
    }

    public function show(Video $video)
    {
        $video->load('comments.user');

        return view('videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        $categories = Category::all();

        return view('videos.edit', compact('video', 'categories'));
    }

    public function update(UpdateVideoRequest $request, Video $video)
    {
        (new VideoService)->update($video, $request->all());

        return to_route('videos.show', $video->slug)->with('alert', __('messages.updated_successfully'));
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return to_route('index')->with('alert', __('messages.success'));
    }
}
