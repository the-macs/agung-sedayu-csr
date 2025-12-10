<?php

namespace App\Filament\Resources\ProjectWeeklyReports\Pages;

use App\Filament\Resources\ProjectWeeklyReports\ProjectWeeklyReportResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectWeeklyReport extends ViewRecord
{
    protected static string $resource = ProjectWeeklyReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
