<?php

namespace Api\Users\Requests;

use Infrastructure\Abstracts\ApiRequest;

class CreateUserRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'password' => 'required|string|min:8'
        ];
    }
}
