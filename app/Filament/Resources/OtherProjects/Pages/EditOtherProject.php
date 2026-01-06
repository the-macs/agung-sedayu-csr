<?php

namespace App\Filament\Resources\OtherProjects\Pages;

use App\Filament\Resources\OtherProjects\OtherProjectResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOtherProject extends EditRecord
{
    protected static string $resource = OtherProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
