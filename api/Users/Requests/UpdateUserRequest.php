<?php

namespace Api\Users\Requests;

use Infrastructure\Abstracts\ApiRequest;

class UpdateUserRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'email' => 'filled|email|unique:users,email',
            'first_name' => 'filled|string',
            'last_name' => 'filled|string',
            'password' => 'filled|string|min:8'
        ];
    }
}
