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

        $sendData = $this->userService->getAll($resourceOptions);

        return $this->response($sendData);
    }

    public function getById($userId)
    {
        $resourceOptions = $this->parseResourceOptions();

        $sendData['user'] = $this->userService->getById($userId, $resourceOptions);

        return $this->response($sendData);
    }

    public function create(CreateUserRequest $request)
    {
        $data = $request->validated();

        $sendData['user'] = $this->userService->create($data);

        return $this->response($sendData, 201);
    }

    public function update($userId, UpdateUserRequest $request)
    {
        $data = $request->validated();

        $sendData['user'] = $this->userService->update($userId, $data);

        return $this->response($sendData);
    }

    public function delete($userId)
    {
        $this->userService->delete($userId);

        return $this->response(null, 204);
    }
}
