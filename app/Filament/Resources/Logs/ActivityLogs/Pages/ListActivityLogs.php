<?php

namespace App\Filament\Resources\Logs\ActivityLogs\Pages;

use App\Filament\Resources\Logs\ActivityLogs\ActivityLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;
}
