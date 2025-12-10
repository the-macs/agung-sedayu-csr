<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectMaterialTrans extends Model
{
    use HasUlids;

    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function projectMaterial(): BelongsTo
    {
        return $this->belongsTo(ProjectMaterial::class);
    }

    public function project()
    {
        return $this->hasOneThrough(
            Project::class,
            ProjectMaterial::class,
            'id', // Foreign key on ProjectMaterial table
            'id', // Foreign key on Project table
            'project_material_id', // Local key on ProjectMaterialTrans table
            'project_id' // Local key on ProjectMaterial table
        );
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'request_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
