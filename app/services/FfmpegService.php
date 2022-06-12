<?php

namespace App\Services;

use FFMpeg\FFProbe;
use Illuminate\Support\Facades\Storage;

class FfmpegService
{
    public function __construct(public string $path)
    {
        $this->ffprobe = FFProbe::create([
                                             'ffmpeg.binaries' => 'C:/ffmpeg/bin/ffmpeg.exe',
                                             'fprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',
                                         ]);
        $this->video_probe = $this->ffprobe->format(Storage::path($path));
    }

    public function getDuration()
    {
        return (int) $this->video_probe->get('duration');
    }
}
