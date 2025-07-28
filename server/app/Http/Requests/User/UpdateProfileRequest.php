<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;

class UpdateProfileRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'username' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9._-]+$/',
                'unique:user_profiles,username,' . $this->route('id'),
            ],
            'avatar' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cover_image' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:4096',
            'state' => 'nullable|integer|in:0,1,2',
            'gender' => 'nullable|integer|in:0,1,2',
            'birthday' => 'nullable|date|before:today',
            'mobile' => 'nullable|string|max:20',
        ];
    }
}
