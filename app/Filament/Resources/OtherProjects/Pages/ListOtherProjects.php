<?php

namespace App\Filament\Resources\OtherProjects\Pages;

use App\Filament\Resources\OtherProjects\OtherProjectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOtherProjects extends ListRecords
{
    protected static string $resource = OtherProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
