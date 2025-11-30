<?php

namespace App\Policies\Settings;

use App\Policies\BasePolicy;

class RolePermissionPolicy extends BasePolicy
{
    protected string $resource = 'role.permission';
}
