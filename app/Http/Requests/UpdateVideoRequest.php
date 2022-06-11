<?php

namespace App\Http\Requests;

class UpdateVideoRequest extends StoreVideoRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'file' => ['file', 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4', 'max:10240', 'nullable'],
        ]);
    }
//    public function rules(): array
//    {
//        return array_merge(parent::rules(), [
//            'slug' => ['required', Rule::unique('videos')->ignore($this->video), 'alpha_dash'],
//        ]);
//    }
}
