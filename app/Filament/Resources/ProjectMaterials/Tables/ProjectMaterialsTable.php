<?php

namespace App\Filament\Resources\ProjectMaterials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProjectMaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->with(['transactions']); // Eager load transactions
            })
            ->columns([
                Tables\Columns\TextColumn::make('project.nama_lengkap')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('uom')
                    ->label('UOM')
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project')
                    ->relationship('project', 'nama_lengkap'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                // 
            ]);
    }
}
