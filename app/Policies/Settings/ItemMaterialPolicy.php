<?php

namespace App\Policies\Settings;

use App\Policies\BasePolicy;

class ItemMaterialPolicy extends BasePolicy
{
    protected string $resource = 'item.material';
}
