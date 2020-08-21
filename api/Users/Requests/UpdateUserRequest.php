<?php

namespace Api\Users\Requests;

use Infrastructure\Http\ApiRequest;

class UpdateUserRequest extends ApiRequest
{
    public function authorize()
    {
        return true;
    }

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

    public function attributes()
    {
        return [
            'user.email' => 'the user\'s email'
        ];
    }
}
