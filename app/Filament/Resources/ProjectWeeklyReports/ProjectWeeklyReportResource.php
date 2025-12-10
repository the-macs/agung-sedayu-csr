<?php

namespace App\Filament\Resources\ProjectWeeklyReports;

use App\Filament\Resources\ProjectWeeklyReports\Pages\CreateProjectWeeklyReport;
use App\Filament\Resources\ProjectWeeklyReports\Pages\EditProjectWeeklyReport;
use App\Filament\Resources\ProjectWeeklyReports\Pages\ListProjectWeeklyReports;
use App\Filament\Resources\ProjectWeeklyReports\Pages\ViewProjectWeeklyReport;
use App\Filament\Resources\ProjectWeeklyReports\Schemas\ProjectWeeklyReportForm;
use App\Filament\Resources\ProjectWeeklyReports\Schemas\ProjectWeeklyReportInfolist;
use App\Filament\Resources\ProjectWeeklyReports\Tables\ProjectWeeklyReportsTable;
use App\Models\ProjectWeeklyReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProjectWeeklyReportResource extends Resource
{
    protected static ?string $model = ProjectWeeklyReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Project Weekly Report';

    public static function form(Schema $schema): Schema
    {
        return ProjectWeeklyReportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProjectWeeklyReportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectWeeklyReportsTable::configure($table);
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
            'index' => ListProjectWeeklyReports::route('/'),
            'create' => CreateProjectWeeklyReport::route('/create'),
            'view' => ViewProjectWeeklyReport::route('/{record}'),
            'edit' => EditProjectWeeklyReport::route('/{record}/edit'),
        ];
    }
}
