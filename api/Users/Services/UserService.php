<?php

namespace Api\Users\Services;

use Illuminate\Events\Dispatcher;
use Api\Users\Exceptions\UserNotFoundException;
use Api\Users\Events\UserWasCreated;
use Api\Users\Events\UserWasDeleted;
use Api\Users\Events\UserWasUpdated;
use Api\Users\Repositories\UserRepository;

class UserService
{
    private $userRepository;
    private $dispatcher;

    public function __construct(
        UserRepository $userRepository,
        Dispatcher $dispatcher
    ) {
        $this->userRepository = $userRepository;
        $this->dispatcher = $dispatcher;
    }

    public function getAll($options = [])
    {
        return $this->userRepository->get($options);
    }

    public function getById($userId, array $options = [])
    {
        $user = $this->getRequestedUser($userId, $options);
        
        return $user;
    }

    public function create($data)
    {
        $user = $this->userRepository->create($data);

        $this->dispatcher->dispatch(new UserWasCreated($user));

        return $user;
    }

    public function update($userId, array $data)
    {
        $user = $this->getRequestedUser($userId);

        $this->userRepository->update($user, $data);

        $this->dispatcher->dispatch(new UserWasUpdated($user));

        return $user;
    }

    public function delete($userId)
    {
        $user = $this->getRequestedUser($userId);

        $this->userRepository->delete($userId);

        $this->dispatcher->dispatch(new UserWasDeleted($user));
    }

    private function getRequestedUser($userId, array $options = [])
    {
        $user = $this->userRepository->getById($userId, $options);

        if (is_null($user)) {
            throw new UserNotFoundException;
        }

        return $user;
    }
}
