<?php

namespace App\Services;

use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Support\Facades\Storage;

class FfmpegService
{
    public function __construct(public string $path)
    {
        $this->ffmpeg = FFMpeg::create();
        $this->ffprobe = FFProbe::create([
                                             'ffmpeg.binaries' => 'C:/ffmpeg/bin/ffmpeg.exe',
                                             'fprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',
                                         ]);
        $this->video_probe = $this->ffprobe->format(Storage::path($path));
        $this->video = $this->ffmpeg->open(Storage::path($path));
    }

    public function getDuration()
    {
        return (int) $this->video_probe->get('duration');
    }

    public function getFrame()
    {
        $frame = $this->video->frame(TimeCode::fromSeconds(1));
        $fileName = pathinfo($this->path, PATHINFO_EXTENSION);
        $storagePath = storage_path('app/public/'.$fileName);
        $frame->save($storagePath);

        return $fileName;
    }
}
