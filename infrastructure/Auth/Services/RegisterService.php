<?php

namespace Infrastructure\Auth\Services;

use Api\Users\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Events\Dispatcher;

class RegisterService
{
    private $userRepository;
    private $dispatcher;

    public function __construct(UserRepository $userRepository, Dispatcher $dispatcher)
    {
        $this->userRepository = $userRepository;
        $this->dispatcher = $dispatcher;
    }

    public function store($data)
    {
        $user = $this->userRepository->create($data);

        $this->dispatcher->dispatch(new Registered($user));

        $sendData['access_token'] = $user->token() ?? $user->createToken('Random-String-Here')->accessToken;

        $sendData['user'] = $user;

        return $sendData;
    }
}
