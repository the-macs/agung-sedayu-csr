<?php

namespace App\Filament\Resources\ProjectWeeklyReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProjectWeeklyReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.nama_lengkap')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('week_number')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        1 => 'gray',
                        2 => 'blue',
                        3 => 'orange',
                        4 => 'green',
                        default => 'gray'
                    })
                    ->formatStateUsing(fn($state) => "Week {$state}"),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('focus')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\IconColumn::make('is_completed')
                    ->boolean()
                    ->label('Completed'),

                Tables\Columns\TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('reporter.name')
                    ->label('Reported By'),
            ])
            ->filters([
                SelectFilter::make('week_number')
                    ->options([
                        1 => 'Week 1',
                        2 => 'Week 2',
                        3 => 'Week 3',
                        4 => 'Week 4',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                // 
            ])
            ->defaultSort('created_at', 'desc');
    }
}
