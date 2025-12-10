<?php

namespace App\Filament\Resources\ProjectMaterials\Pages;

use App\Filament\Resources\ProjectMaterials\ProjectMaterialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProjectMaterial extends EditRecord
{
    protected static string $resource = ProjectMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }
}
