<?php

namespace App\Repositories;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Interfaces\InterfaceUsers;
use App\Models\User;

class UsersRepo implements InterfaceUsers
{
    /**
     * @param UserCreateRequest $request
     * @return mixed|void
     */
    public function store(UserCreateRequest $request)
    {
        $user = new User();

        $user->name              = request('name');
        $user->email             = request('email');
        $user->password          = bcrypt(request('password'));
        $user->email_verified_at = now();

        $user->save();

        $user->asignarRol($request->get('rol'));
    }

    /**
     * @param UserUpdateRequest $request
     * @param User $user
     */
    public function update(UserUpdateRequest $request, User $user): void
    {
        $user->update($request->all());

        $user->roles()->sync($request->get('rol'));
    }

    /**
     * @param User $user
     */
    public function active(User $user): void
    {
        $state = $user->active;
        $user->active = !$state;

        $user->update();
    }
}
