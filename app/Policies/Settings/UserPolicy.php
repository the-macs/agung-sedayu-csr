<?php

namespace App\Policies\Settings;

use App\Policies\BasePolicy;

class UserPolicy extends BasePolicy
{
    protected string $resource = 'user';
}
