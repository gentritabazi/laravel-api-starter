<?php

namespace Api\Users\Services;

use Illuminate\Events\Dispatcher;
use Api\Users\Events\UserWasCreated;
use Api\Users\Events\UserWasDeleted;
use Api\Users\Events\UserWasUpdated;
use Illuminate\Support\Facades\Gate;
use Api\Users\Repositories\UserRepository;
use Api\Users\Exceptions\UserNotFoundException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
        return $this->userRepository->getWithCount($options);
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

        if (Gate::denies('update-user', $user)) {
            throw new AccessDeniedHttpException('Cannot update this user.');
        }

        $this->userRepository->update($user, $data);

        $this->dispatcher->dispatch(new UserWasUpdated($user));
    }

    public function delete($userId)
    {
        $user = $this->getRequestedUser($userId, ['select' => ['id']]);

        $this->userRepository->delete($userId);

        $this->dispatcher->dispatch(new UserWasDeleted($user));

        return $user;
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
