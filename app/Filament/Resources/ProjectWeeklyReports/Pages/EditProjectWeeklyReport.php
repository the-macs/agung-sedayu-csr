<?php

namespace App\Filament\Resources\ProjectWeeklyReports\Pages;

use App\Filament\Resources\ProjectWeeklyReports\ProjectWeeklyReportResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProjectWeeklyReport extends EditRecord
{
    protected static string $resource = ProjectWeeklyReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
