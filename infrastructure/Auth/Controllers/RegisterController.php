<?php

namespace Infrastructure\Auth\Controllers;

use Infrastructure\Abstracts\Controller;
use Infrastructure\Auth\Requests\RegisterRequest;
use Infrastructure\Auth\Services\RegisterService;

class RegisterController extends Controller
{
    private $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }
    
    public function store(RegisterRequest $request)
    {
        $sendData = $this->registerService->store($request->validated());

        return $this->response($sendData);
    }
}
