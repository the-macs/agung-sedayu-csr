<?php

namespace App\Policies\Settings;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can("view.any.setting");
    }

    public function update(User $user, string $settingType): bool
    {
        return $user->hasPermissionTo("update.$settingType.setting");
    }

    public function bypassMaintenance(User $user): bool
    {
        return $user->hasPermissionTo('bypass.maintenance.setting');
    }
}
