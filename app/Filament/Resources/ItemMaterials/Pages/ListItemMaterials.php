<?php

namespace App\Filament\Resources\ItemMaterials\Pages;

use App\Filament\Resources\ItemMaterials\ItemMaterialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListItemMaterials extends ListRecords
{
    protected static string $resource = ItemMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
