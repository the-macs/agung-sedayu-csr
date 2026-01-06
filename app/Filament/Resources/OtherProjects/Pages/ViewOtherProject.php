<?php

namespace App\Filament\Resources\OtherProjects\Pages;

use App\Filament\Resources\OtherProjects\OtherProjectResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOtherProject extends ViewRecord
{
    protected static string $resource = OtherProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->visible(function ($record) {
                    return $record->status === 'draft';
                }),
        ];
    }

    // Enable relation managers on view page
    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
