<?php

namespace App\Filament\Resources\Settings\Roles\Pages;

use App\Filament\Resources\Settings\Roles\RoleResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function afterSave(): void
    {
        $permissions = $this->data['permissions'] ?? [];

        $this->record->syncPermissions($permissions);
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->color('gray')
            ->url($this->getResource()::getUrl('index'));
    }
}
