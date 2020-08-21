<?php

namespace Api\Users\Services;

use Exception;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Api\Users\Events\UserWasCreated;
use Api\Users\Events\UserWasDeleted;
use Api\Users\Events\UserWasUpdated;
use Api\Users\Repositories\UserRepository;
use Api\Users\Exceptions\UserNotFoundException;

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
        try {
            DB::beginTransaction();

            $user = $this->userRepository->create($data);

            $this->dispatcher->dispatch(new UserWasCreated($user));

            DB::commit();
            
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($userId, array $data)
    {
        try {
            $user = $this->getRequestedUser($userId);

            $this->userRepository->update($user, $data);

            $this->dispatcher->dispatch(new UserWasUpdated($user));

            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($userId)
    {
        try {
            $user = $this->getRequestedUser($userId);

            $this->userRepository->delete($userId);

            $this->dispatcher->dispatch(new UserWasDeleted($user));

            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
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
