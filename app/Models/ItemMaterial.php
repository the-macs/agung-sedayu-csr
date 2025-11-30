<?php

namespace App\Models;

use App\Policies\Settings\ItemMaterialPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[UsePolicy(ItemMaterialPolicy::class)]
class ItemMaterial extends Model
{
    use HasUlids, LogsActivity;

    protected $fillable = [
        'name',
        'quantity',
        'uom_id',
        'description',
    ];

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
            ->useLogName('item.material')
            ->setDescriptionForEvent(fn(string $eventName) => "Item Material has been {$eventName}");
    }
}
