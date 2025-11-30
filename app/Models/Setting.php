<?php

namespace App\Models;

use App\Policies\Settings\SettingPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[UsePolicy(SettingPolicy::class)]
class Setting extends Model
{
    use LogsActivity;

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    protected $fillable = ['key', 'value', 'type'];

    /**
     * Log Activities
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['key', 'value', 'type'])  // fields to track
            ->logOnlyDirty()                     // only log changed values
            ->dontSubmitEmptyLogs()              // skip logs with no changes
            ->useLogName('settings')             // log name in DB
            ->setDescriptionForEvent(fn(string $eventName) => "Setting " . Str::headline($this->key) . " was {$eventName}");
    }

}
