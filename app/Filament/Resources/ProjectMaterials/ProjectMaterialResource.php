<?php

namespace App\Filament\Resources\ProjectMaterials;

use App\Filament\Resources\ProjectMaterials\Pages\CreateProjectMaterial;
use App\Filament\Resources\ProjectMaterials\Pages\EditProjectMaterial;
use App\Filament\Resources\ProjectMaterials\Pages\ListProjectMaterials;
use App\Filament\Resources\ProjectMaterials\Pages\ViewProjectMaterial;
use App\Filament\Resources\ProjectMaterials\RelationManagers\TransactionsRelationManager;
use App\Filament\Resources\ProjectMaterials\Schemas\ProjectMaterialForm;
use App\Filament\Resources\ProjectMaterials\Tables\ProjectMaterialsTable;
use App\Models\ProjectMaterial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProjectMaterialResource extends Resource
{
    protected static ?string $model = ProjectMaterial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Cube;

    protected static ?string $recordTitleAttribute = 'Project Material';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return ProjectMaterialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectMaterialsTable::configure($table);
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
            'index' => ListProjectMaterials::route('/'),
            'create' => CreateProjectMaterial::route('/create'),
            'edit' => EditProjectMaterial::route('/{record}/edit'),
            'view' => ViewProjectMaterial::route('/{record}/view'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }
}
