<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Filament\Actions\FinishProjectAction;
use App\Filament\Actions\StartProjectAction;
use App\Models\Project;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama_panggilan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nik')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kecamatan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('desa_kelurahan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('no_whatsapp')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kecamatan')
                    ->options(Project::KECAMATAN)
                    ->placeholder('Semua Kecamatan'),
                SelectFilter::make('pernah_bantuan')
                    ->options(Project::YA_TIDAK)
                    ->placeholder('Semua Status Bantuan'),
                SelectFilter::make('terdaftar_bansos')
                    ->options(Project::YA_TIDAK)
                    ->placeholder('Semua Status Bansos'),
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn($q) => $q->whereDate('created_at', '>=', $data['created_from']))
                            ->when($data['created_until'], fn($q) => $q->whereDate('created_at', '<=', $data['created_until']));
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->icon('heroicon-o-eye'),
                EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->visible(function ($record) {
                        return $record->status === 'draft';
                    }),
                StartProjectAction::make('start_project'),
                FinishProjectAction::make('finish_project'),
            ])
            ->emptyStateActions([
                CreateAction::make()
                    ->icon('heroicon-o-plus')
                    ->label('Tambah Project Baru'),
            ])
            ->toolbarActions([
                //    
            ]);
    }
}
