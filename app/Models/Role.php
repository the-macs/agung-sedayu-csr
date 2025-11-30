<?php

namespace App\Models;

use App\Policies\Settings\RolePermissionPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;

#[UsePolicy(RolePermissionPolicy::class)]
class Role extends SpatieRole
{
    use HasUlids, LogsActivity;

    protected $keyType = 'string';

    /**
     * Log Activities
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'guard_name'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('role')
            ->setDescriptionForEvent(fn(string $eventName) => "Role has been {$eventName}");
    }

    /**
     * Sync Permissions with Activity Log
     *
     * @param mixed ...$permissions
     * @return $this
     */
    public function syncPermissions(...$permissions)
    {
        $oldPermissions = $this->permissions->pluck('name')->toArray();

        $result = parent::syncPermissions(...$permissions);

        $this->refresh();
        $newPermissions = $this->permissions->pluck('name')->toArray();

        if ($oldPermissions != $newPermissions) {
            $added = array_diff($newPermissions, $oldPermissions);
            $removed = array_diff($oldPermissions, $newPermissions);

            activity('permission')
                ->event('updated')
                ->by(Auth::user()->id)
                ->performedOn($this)
                ->withProperties([
                    "attributes" => [
                        'added' => array_values($added),
                        'removed' => array_values($removed),
                    ],
                ])
                ->log('Role permissions updated');
        }

        return $result;
    }
}
