<?php

namespace App\Filament\Resources\Logs\ActivityLogs\Tables;

use App\Filament\Resources\Logs\ActivityLogs\ActivityLogResource;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event')
                    ->badge()
                    ->label('Action')
                    ->colors([
                        'success' => fn($state): bool => in_array($state, ['created', 'submitted'], true),
                        'warning' => fn($state): bool => $state === 'updated',
                        'danger'  => fn($state): bool => in_array($state, ['deleted', 'logout'], true),
                        'info'    => fn($state): bool => $state === 'login',
                    ])
                    ->icons([
                        'heroicon-o-plus' => 'created',
                        'heroicon-o-pencil' => 'updated',
                        'heroicon-o-trash' => 'deleted',
                        'heroicon-o-arrow-right-end-on-rectangle' => 'login',
                        'heroicon-o-arrow-left-on-rectangle' => 'logout',
                        'heroicon-o-paper-airplane' => 'submitted',
                    ])
                    ->sortable(),

                TextColumn::make('log_name')
                    ->label('Module')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('causer.name')
                    ->label('User')
                    ->placeholder('System')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('subject_type')
                    ->label('Subject')
                    ->default('-')
                    ->formatStateUsing(fn($state) => $state)
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->placeholder('No description')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                    ])
                    ->label('Action'),

                SelectFilter::make('today')
                    ->label('Today')
                    ->query(fn($query) => $query->whereDate('created_at', today())),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make()
                    ->tooltip('View Details')
                    ->slideOver()
                    ->modalWidth(Width::ScreenExtraLarge)
                    ->stickyModalFooter()
                    ->visible(fn ($record) => auth()->user()->can('view', $record)),
            ])
            ->toolbarActions([]);
    }
}
