<?php

namespace App\Models;

use App\Policies\Settings\ItemMaterialPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[UsePolicy(ItemMaterialPolicy::class)]
class ItemMaterial extends Model
{
    use HasUlids, LogsActivity;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'quantity',
        'uom_id',
        'description',
    ];
    
    public function uom(): BelongsTo
    {
        return $this->belongsTo(Uom::class);
    }

    /**
     * Log Activities
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name','quantity','uom_id','description'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('item.material')
            ->setDescriptionForEvent(fn(string $eventName) => "Item Material has been {$eventName}");
    }
}
