<?php

namespace Api\Users\Controllers;

use Api\Users\Services\UserService;
use Infrastructure\Abstracts\Controller;
use Api\Users\Requests\CreateUserRequest;
use Api\Users\Requests\UpdateUserRequest;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getAll()
    {
        $resourceOptions = $this->parseResourceOptions();

        $data = $this->userService->getAll($resourceOptions);

        return $this->response($data);
    }

    public function getById($userId)
    {
        $resourceOptions = $this->parseResourceOptions();

        $data = $this->userService->getById($userId, $resourceOptions);

        return $this->response(data);
    }

    public function create(CreateUserRequest $request)
    {
        $data = $request->get('user', []);

        return $this->response($this->userService->create($data), 201);
    }

    public function update($userId, UpdateUserRequest $request)
    {
        $data = $request->get('user', []);

        return $this->response($this->userService->update($userId, $data));
    }

    public function delete($userId)
    {
        return $this->response($this->userService->delete($userId));
    }
}
