<?php

namespace App\Filament\Resources\OtherProjects;

use App\Filament\Resources\OtherProjects\Pages\CreateOtherProject;
use App\Filament\Resources\OtherProjects\Pages\EditOtherProject;
use App\Filament\Resources\OtherProjects\Pages\ListOtherProjects;
use App\Filament\Resources\OtherProjects\Pages\ViewOtherProject;
use App\Filament\Resources\OtherProjects\Schemas\OtherProjectForm;
use App\Filament\Resources\OtherProjects\Schemas\OtherProjectInfolist;
use App\Filament\Resources\OtherProjects\Tables\OtherProjectsTable;
use App\Filament\Resources\Projects\RelationManagers\MaterialsRelationManager;
use App\Filament\Resources\Projects\RelationManagers\WeeklyReportsRelationManager;
use App\Models\OtherProject;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OtherProjectResource extends Resource
{
    protected static ?string $model = OtherProject::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Briefcase;

    protected static ?string $recordTitleAttribute = 'OtherProject';

    public static function form(Schema $schema): Schema
    {
        return OtherProjectForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OtherProjectInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OtherProjectsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MaterialsRelationManager::class,
            WeeklyReportsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOtherProjects::route('/'),
            'create' => CreateOtherProject::route('/create'),
            'view' => ViewOtherProject::route('/{record}'),
            'edit' => EditOtherProject::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'ongoing')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('status', 'ongoing')->count() > 0 ? 'success' : 'gray';
    }
}
