<?php

namespace App\Models;

use App\Policies\Logs\ActivityPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

#[UsePolicy(ActivityPolicy::class)]
class Activity extends \Spatie\Activitylog\Models\Activity
{
    //
}
