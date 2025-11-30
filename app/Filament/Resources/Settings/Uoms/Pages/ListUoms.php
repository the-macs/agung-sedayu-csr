<?php

namespace App\Filament\Resources\Settings\Uoms\Pages;

use App\Filament\Resources\Settings\Uoms\UomResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUoms extends ListRecords
{
    protected static string $resource = UomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
