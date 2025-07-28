<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;

class VerifyOtpRegisterRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'verify_key'  => 'required|string',
            'otp' => 'required|string|min:6',
        ];
    }
}
