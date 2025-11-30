<?php

namespace App\Filament\Resources\Settings\Roles\Pages;

use App\Filament\Resources\Settings\Roles\RoleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected array $permissionsToSync = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        $this->permissionsToSync = $permissions;

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->syncPermissions($this->permissionsToSync);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl(
            'edit',
            ['record' => $this->record]
        );
    }
}
