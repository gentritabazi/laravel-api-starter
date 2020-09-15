<?php

namespace Api\Users\Requests;

use Infrastructure\Http\ApiRequest;

class CreateUserRequest extends ApiRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user' => 'array|required',
            'user.email' => 'required|email|unique:users,email',
            'user.first_name' => 'required|string',
            'user.last_name' => 'required|string',
            'user.password' => 'required|string|min:8'
        ];
    }
}
