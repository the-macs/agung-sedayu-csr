<?php

namespace App\Filament\Resources\ProjectWeeklyReports\Pages;

use App\Filament\Resources\ProjectWeeklyReports\ProjectWeeklyReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProjectWeeklyReports extends ListRecords
{
    protected static string $resource = ProjectWeeklyReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
