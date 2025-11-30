<?php

namespace App\Policies\Logs;

use App\Policies\BasePolicy;

class ActivityPolicy extends BasePolicy
{
    protected string $resource = 'log.activity';
}
