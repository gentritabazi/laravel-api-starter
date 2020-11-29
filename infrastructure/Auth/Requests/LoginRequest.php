<?php

namespace Infrastructure\Auth\Requests;

use Infrastructure\Abstracts\ApiRequest;

class LoginRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
}
