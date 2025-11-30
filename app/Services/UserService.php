<?php

namespace App\Services;

use App\Models\User;

class UserService extends BaseService
{
    /**
     * Dependencies for this Service
     */
    public function __construct()
    {
        $this->model = new User;
    }
}
