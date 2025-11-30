<?php

namespace App\Filament\Resources\Settings\Users\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('username')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
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
                            ->log('Updated roles for user: '.$record->name);
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
