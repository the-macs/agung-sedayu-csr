<?php

namespace App\Filament\Resources\Settings\ItemMaterials\Pages;

use App\Filament\Resources\Settings\ItemMaterials\ItemMaterialResource;
use Filament\Resources\Pages\CreateRecord;

class CreateItemMaterial extends CreateRecord
{
    protected static string $resource = ItemMaterialResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
