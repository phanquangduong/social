<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;

class ResetPasswordRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}
