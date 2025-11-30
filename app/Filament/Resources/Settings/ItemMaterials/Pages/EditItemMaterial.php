<?php

namespace App\Filament\Resources\Settings\ItemMaterials\Pages;

use App\Filament\Resources\Settings\ItemMaterials\ItemMaterialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditItemMaterial extends EditRecord
{
    protected static string $resource = ItemMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
