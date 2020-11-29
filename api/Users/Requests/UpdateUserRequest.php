<?php

namespace Api\Users\Requests;

use Infrastructure\Abstracts\ApiRequest;

class UpdateUserRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'user' => 'array|required',
            'user.email' => 'filled|email|unique:users,email',
            'user.first_name' => 'filled|string',
            'user.last_name' => 'filled|string',
            'user.password' => 'filled|string|min:8'
        ];
    }
}
