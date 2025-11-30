<?php

namespace App\Filament\Resources\Settings\Uoms\Pages;

use App\Filament\Resources\Settings\Uoms\UomResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUom extends EditRecord
{
    protected static string $resource = UomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
