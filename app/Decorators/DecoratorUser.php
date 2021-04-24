<?php

namespace App\Decorators;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UsersRepo;
use App\Interfaces\InterfaceUsers;
use Illuminate\Support\Facades\Cache;

class DecoratorUser implements InterfaceUsers
{
    protected $usersRepo;

    /**
     * DecoratorUser constructor.
     * @param UsersRepo $usersRepo
     */
    public function __construct(UsersRepo $usersRepo)
    {
        $this->usersRepo = $usersRepo;
    }

    /**
     * @param UserCreateRequest $request
     * @return mixed|void
     */
    public function store(UserCreateRequest $request)
    {
        $this->usersRepo->store($request);

        Cache::tags('users')->flush();
    }

    /**
     * @param UserUpdateRequest $request
     * @param User $user
     */
    public function update(UserUpdateRequest $request, User $user): void
    {
        $this->usersRepo->update($request, $user);

        Cache::tags('users')->flush();
    }

    /**
     * @param User $user
     */
    public function active(User $user): void
    {
        $this->usersRepo->active($user);

        Cache::tags('users')->flush();
    }
}
