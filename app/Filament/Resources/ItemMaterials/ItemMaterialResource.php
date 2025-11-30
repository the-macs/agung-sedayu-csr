<?php

namespace App\Filament\Resources\ItemMaterials;

use App\Filament\Resources\ItemMaterials\Pages\CreateItemMaterial;
use App\Filament\Resources\ItemMaterials\Pages\EditItemMaterial;
use App\Filament\Resources\ItemMaterials\Pages\ListItemMaterials;
use App\Filament\Resources\ItemMaterials\Schemas\ItemMaterialForm;
use App\Filament\Resources\ItemMaterials\Tables\ItemMaterialsTable;
use App\Models\ItemMaterial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ItemMaterialResource extends Resource
{
    protected static ?string $model = ItemMaterial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Item Material';

    public static function form(Schema $schema): Schema
    {
        return ItemMaterialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ItemMaterialsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItemMaterials::route('/'),
            'create' => CreateItemMaterial::route('/create'),
            'edit' => EditItemMaterial::route('/{record}/edit'),
        ];
    }
}
