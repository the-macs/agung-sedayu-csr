<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OtherProjectWeeklyReport extends Model
{
    use HasUlids;

    protected $guarded = [];

    protected $casts = [
        'photos' => 'array',
    ];

    public function otherProject(): BelongsTo
    {
        return $this->belongsTo(OtherProject::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
