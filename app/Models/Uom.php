<?php

namespace App\Models;

use App\Policies\Settings\UomPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[UsePolicy(UomPolicy::class)]
class Uom extends Model
{
    use HasUlids, LogsActivity, SoftDeletes;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'abbreviation',
    ];

    public function itemMaterials(): HasMany
    {
        return $this->hasMany(ItemMaterial::class);
    }

    /**
     * Log Activities
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name','abbreviation'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('uom')
            ->setDescriptionForEvent(fn(string $eventName) => "Uom has been {$eventName}");
    }
}
