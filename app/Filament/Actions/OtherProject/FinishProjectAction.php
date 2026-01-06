<?php

namespace App\Filament\Actions\OtherProject;

use App\Models\OtherProject;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class FinishProjectAction extends Action
{
    public static function make(?string $name = null): static
    {
        return parent::make($name ?? 'finish_project')
            ->label('Finish Project')
            ->icon('heroicon-o-check')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Finish Project')
            ->modalDescription('Are you sure you want to finish this project? This will:
                - Change project status to "Finish"
                - This action cannot be undone')
            ->modalIcon('heroicon-o-play')
            ->modalSubmitActionLabel('Yes, Finish Project')
            ->action(function (OtherProject $record): void {
                // Start the project
                $record->endProject();

                Notification::make()
                    ->title('Project Finish Successfully')
                    ->body("Project status changed to Finish.")
                    ->success()
                    ->send();
            })
            ->visible(fn(OtherProject $record): bool => $record->canBeFinish());
    }
}
