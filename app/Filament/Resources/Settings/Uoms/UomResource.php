<?php

namespace App\Filament\Resources\Settings\Uoms;

use App\Filament\Resources\Settings\Uoms\Pages\CreateUom;
use App\Filament\Resources\Settings\Uoms\Pages\EditUom;
use App\Filament\Resources\Settings\Uoms\Pages\ListUoms;
use App\Filament\Resources\Settings\Uoms\Schemas\UomForm;
use App\Filament\Resources\Settings\Uoms\Tables\UomsTable;
use App\Models\Uom;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UomResource extends Resource
{
    protected static ?string $model = Uom::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Scale;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $recordTitleAttribute = 'Unit of Measurement';

    public static function form(Schema $schema): Schema
    {
        return UomForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UomsTable::configure($table);
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
            'index' => ListUoms::route('/'),
            'create' => CreateUom::route('/create'),
            'edit' => EditUom::route('/{record}/edit'),
        ];
    }
}
