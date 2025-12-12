<?php

namespace App\Filament\Resources\Settings\Users\Pages;

use App\Filament\Resources\Settings\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // make assign role to user after create
    protected function afterCreate(): void
    {
        $this->record->assignRole('user');
    }
}
