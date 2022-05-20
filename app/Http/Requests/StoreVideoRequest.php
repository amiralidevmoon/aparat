<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required'],
            'length' => ['required', 'integer'],
            'file' => ['required', 'file', 'mimetypes:video/avi,video/mpeg,video/quicktime', 'max:10240'], // 10 MB
            'thumbnail' => ['required', 'url'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function messages()
    {
        return [
            'file.*' => 'فایل باید ویدیویی باشد',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
//    protected function prepareForValidation(): void
//    {
//        $this->merge([
//            'slug' => Str::slug($this->slug),
//        ]);
//    }
}
