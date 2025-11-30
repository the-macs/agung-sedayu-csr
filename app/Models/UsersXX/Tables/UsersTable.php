<?php

namespace App\Filament\Resources\Settings\Users\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Support\Facades\Auth;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('company.name')->label('Company'),
                TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->separator(', ')
                    ->color('info')
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('name')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->tooltip('View Details')
                    ->slideOver()
                    ->modalWidth(Width::ThreeExtraLarge)
                    ->stickyModalFooter(),
                EditAction::make()
                    ->before(function ($record) use (&$oldRoles) {
                        $oldRoles = $record->roles()->pluck('name')->toArray();
                    })
                    ->after(function ($record) use (&$oldRoles) {
                        $newRoles = $record->roles()->pluck('name')->toArray();

                        activity('user')
                            ->event('updated')
                            ->by(Auth::user())
                            ->performedOn($record)
                            ->withProperties([
                                'attributes' => [
                                    'old_roles' => $oldRoles,
                                    'new_roles' => $newRoles,
                                ],
                            ])
                            ->log('Updated roles for user: ' . $record->name);
                    })
            ])
            ->toolbarActions([
                //
            ]);
    }
}
