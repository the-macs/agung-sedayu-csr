<?php

namespace App\Filament\Resources\Settings\Roles\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class RoleTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Role Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('permissions_count')
                    ->label('Permissions')
                    ->counts('permissions') // uses Eloquent withCount()
                    ->badge()
                    ->color('success'),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('permissions')
                    ->relationship('permissions', 'name')
                    ->label('Filter by Permission')
                    ->searchable()
                    ->native(false)
                    ->multiple(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->visible(fn($record) => auth()->user()->can('view', $record)),
                EditAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
