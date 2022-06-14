<?php

namespace App\services;

use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

class VideoService
{
    public function create(User $user, array $data)
    {
        $data = $this->prepareDataFile($data);

        return $user->videos()->create($data);
    }

    public function update(Video $video, array $data)
    {
        if (array_key_exists('file', $data) && $data['file'] instanceof File) {
            $data = $this->prepareDataFile($data);
        }

        return $video->update($data);
    }

    private function prepareDataFile(array $data)
    {
        $videoPath = Storage::putFile('', $data['file']);

        $ffmpegService = new FfmpegService($videoPath);

        $data['url'] = $videoPath;
        $data['length'] = $ffmpegService->getDuration();
        $data['thumbnail'] = $ffmpegService->getFrame();

        return $data;
    }
}
