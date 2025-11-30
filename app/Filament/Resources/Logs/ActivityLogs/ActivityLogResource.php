<?php

namespace App\Filament\Resources\Logs\ActivityLogs;

use App\Models\Activity;
use BackedEnum;
use UnitEnum;
use App\Filament\Resources\Logs\ActivityLogs\Pages\ListActivityLogs;
use App\Filament\Resources\Logs\ActivityLogs\Schemas\ActivityLogForm;
use App\Filament\Resources\Logs\ActivityLogs\Schemas\ActivityLogInfolist;
use App\Filament\Resources\Logs\ActivityLogs\Tables\ActivityLogsTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::ClipboardDocumentList;

    protected static ?string $navigationLabel = 'Activity Logs';

    protected static string|UnitEnum|null $navigationGroup = 'Logs';

    protected static ?int $navigationSort = 98;

    public static function form(Schema $schema): Schema
    {
        return ActivityLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ActivityLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivityLogsTable::configure($table);
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
            'index' => ListActivityLogs::route('/'),
        ];
    }
}
