<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Models\OtherProject;
use App\Models\ProjectWeeklyReport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WeeklyReportsRelationManager extends RelationManager
{
    protected static string $relationship = 'otherWeeklyReports';

    protected static bool $canViewForRecord = true;

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Mingguan')
                    ->schema([
                        // Remove the project_id Select - it's automatically handled by the relation

                        TextInput::make('week_number')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(52),

                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('focus')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Dokumentasi & Bukti')
                    ->schema([
                        FileUpload::make('photos')
                            ->required()
                            ->image()
                            ->directory('other_weekly_report')
                            ->maxSize(2048)
                            ->label('Foto Dokumentasi')
                            ->helperText('Upload foto tampak depan rumah')
                            ->multiple(),
                    ])
                    ->columns(1),

                Section::make('Catatan Tambahan')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Catatan Minggu Ini')
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->rows(10),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Weekly Reports')
            ->columns([
                Tables\Columns\TextColumn::make('week_number')
                    ->badge()
                    ->formatStateUsing(fn($state) => "Week {$state}"),

                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('focus')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('reporter.name')
                    ->label('Reported By'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Weekly Report')
                    ->visible(fn() => $this->getOwnerRecord()->status === OtherProject::STATUS_ONGOING)
                    ->modalWidth('7xl'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->defaultSort('week_number', 'asc');
    }
}
