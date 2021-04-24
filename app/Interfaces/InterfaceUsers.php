<?php

namespace App\Interfaces;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;

interface InterfaceUsers
{
    /**
     * @param UserCreateRequest $request
     * @return mixed
     */
    public function store(UserCreateRequest $request);

    /**
     * @param UserUpdateRequest $request
     * @param User $user
     * @return mixed
     */
    public function update(UserUpdateRequest $request, User $user);

    /**
     * @param User $user
     * @return mixed
     */
    public function active(User $user);
}
