<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, User $model): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, User $model): bool
    {
        //
    }

    public function delete(User $user, User $model): Response
    {
        return ($user->id === $model->user_id)
            ? Response::allow()
            : Response::deny('You can not delete else user.');
    }

    public function restore(User $user, User $model): bool
    {
        //
    }

    public function forceDelete(User $user, User $model): bool
    {
        //
    }
}
