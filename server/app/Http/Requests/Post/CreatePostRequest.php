<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\BaseFormRequest;

class CreatePostRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'content'    => 'nullable|string|max:10000',
            'visibility' => 'required|in:public,friends,private',
            'media'      => 'nullable|array',
            'media.*'    => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
        ];
    }
}
