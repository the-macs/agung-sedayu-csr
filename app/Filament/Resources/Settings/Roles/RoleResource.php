<?php

namespace App\Filament\Resources\Settings\Roles;

use UnitEnum;
use BackedEnum;
use App\Models\Role;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Settings\Roles\Pages\EditRole;
use App\Filament\Resources\Settings\Roles\Pages\ListRoles;
use App\Filament\Resources\Settings\Roles\Pages\CreateRole;
use App\Filament\Resources\Settings\Roles\Schemas\RoleForm;
use App\Filament\Resources\Settings\Roles\Tables\RoleTable;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::ShieldCheck;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 96;

    public static function form(Schema $schema): Schema
    {
        return RoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RoleTable::configure($table);
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
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
