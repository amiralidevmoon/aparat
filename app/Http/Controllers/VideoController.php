<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Category;
use App\Models\Video;
use App\Services\FfmpegService;
use Illuminate\Support\Facades\Storage;

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
        $videoPath = Storage::putFile('', $request->file);

        $ffmpegService = new FfmpegService($videoPath);

        $request->merge([
                            'url' => $videoPath,
                            'length' => $ffmpegService->getDuration(),
                        ]);

        $request->user()->videos()->create($request->all());

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
        if ($request->hasFile('file')) {
            $videoPath = Storage::putFile('', $request->file);

            $ffmpegService = new FfmpegService($videoPath);

            $request->merge([
                                'url' => $videoPath,
                                'length' => $ffmpegService->getDuration(),
                            ]);
        }
        $video->update($request->all());

        return to_route('videos.show', $video->slug)->with('alert', __('messages.updated_successfully'));
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return to_route('index')->with('alert', __('messages.success'));
    }
}
