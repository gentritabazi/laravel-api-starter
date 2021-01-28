<?php

namespace Infrastructure\Auth\Controllers;

use Infrastructure\Auth\Services\LoginService;
use Infrastructure\Auth\Requests\LoginRequest;
use Infrastructure\Abstracts\Controller;

class LoginController extends Controller
{
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(LoginRequest $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        return $this->response($this->loginService->attemptLogin($email, $password));
    }

    public function refresh()
    {
        return $this->response($this->loginService->attemptRefresh());
    }

    public function logout()
    {
        $this->loginService->logout();

        return $this->response(null, 204);
    }
}
