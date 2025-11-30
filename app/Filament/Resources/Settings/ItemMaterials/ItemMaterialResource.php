<?php

namespace App\Filament\Resources\Settings\ItemMaterials;

use App\Filament\Resources\Settings\ItemMaterials\Pages\CreateItemMaterial;
use App\Filament\Resources\Settings\ItemMaterials\Pages\EditItemMaterial;
use App\Filament\Resources\Settings\ItemMaterials\Pages\ListItemMaterials;
use App\Filament\Resources\Settings\ItemMaterials\Schemas\ItemMaterialForm;
use App\Filament\Resources\Settings\ItemMaterials\Tables\ItemMaterialsTable;
use App\Models\ItemMaterial;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;    
use Filament\Tables\Table;

class ItemMaterialResource extends Resource
{
    protected static ?string $model = ItemMaterial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Cube;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

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
