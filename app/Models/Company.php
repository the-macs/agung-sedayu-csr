<?php

namespace App\Models;

use App\Policies\Settings\CompanyPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(CompanyPolicy::class)]
class Company extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';

    protected $guarded = [];
}
