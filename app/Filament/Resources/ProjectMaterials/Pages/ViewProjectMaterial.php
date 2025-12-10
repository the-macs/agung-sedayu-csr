<?php

namespace App\Filament\Resources\ProjectMaterials\Pages;

use App\Filament\Resources\ProjectMaterials\ProjectMaterialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectMaterial extends ViewRecord
{
    protected static string $resource = ProjectMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
