<?php

namespace App\Filament\Actions;

use App\Models\Project;
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
                - Generate default materials from item materials
                - This action cannot be undone')
            ->modalIcon('heroicon-o-play')
            ->modalSubmitActionLabel('Yes, Start Project')
            ->action(function (Project $record): void {

                // Start the project
                $record->startProject();

                // Generate materials from default item materials
                $record->generateMaterialsFromDefaults();

                // Get the count of materials generated
                $materialsCount = $record->projectMaterials()->count();

                Notification::make()
                    ->title('Project Started Successfully')
                    ->body("Project status changed to Ongoing. {$materialsCount} materials have been automatically generated.")
                    ->success()
                    ->send();
            })
            ->visible(fn(Project $record): bool => $record->canBeStarted());
    }
}
