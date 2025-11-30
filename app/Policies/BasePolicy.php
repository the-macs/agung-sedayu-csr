<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class BasePolicy
{
    use HandlesAuthorization;

    protected string $resource;

    public function viewAny(User $user): bool
    {
        return $user->can("view.any.{$this->resource}");
    }

    public function view(User $user, Model $model): bool
    {
        return $user->can("view.{$this->resource}");
    }

    public function create(User $user): bool
    {
        return $user->can("create.{$this->resource}");
    }

    public function update(User $user, Model $model): bool
    {
        return $user->can("update.{$this->resource}");
    }

    public function delete(User $user, Model $model): bool
    {
        return $user->can("delete.{$this->resource}");
    }

    public function restore(User $user, Model $model): bool
    {
        return $user->can("restore.{$this->resource}");
    }

    public function forceDelete(User $user, Model $model): bool
    {
        return $user->can("force.delete.{$this->resource}");
    }

    public function sync(User $user): bool
    {
        return $user->can("sync.{$this->resource}");
    }
}
