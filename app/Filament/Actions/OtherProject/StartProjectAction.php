<?php

namespace App\Filament\Actions\OtherProject;

use App\Models\OtherProject;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class StartProjectAction extends Action
{
    public static function make(?string $name = null): static
    {
        return parent::make($name ?? 'start_project')
            ->label('Start Project')
            ->icon('heroicon-o-play')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Start Project')
            ->modalDescription('Are you sure you want to start this project? This will:
                - Change project status to "Ongoing"
                - This action cannot be undone')
            ->modalIcon('heroicon-o-play')
            ->modalSubmitActionLabel('Yes, Start Project')
            ->action(function (OtherProject $record): void {

                // Start the project
                $record->startProject();

                Notification::make()
                    ->title('Project Started Successfully')
                    ->body("Project status changed to Ongoing.")
                    ->success()
                    ->send();
            })
            ->visible(fn(OtherProject $record): bool => $record->canBeStarted());
    }
}
