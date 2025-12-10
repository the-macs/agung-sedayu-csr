<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\ProjectWeeklyReports\ProjectWeeklyReportResource;
use App\Models\ProjectWeeklyReport;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WeeklyReportsRelationManager extends RelationManager
{
    protected static string $relationship = 'weeklyReports';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Mingguan')
                    ->schema([
                        Select::make('project_id')
                            ->relationship('project', 'nama_lengkap')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $nextWeek = ProjectWeeklyReport::getNextWeekNumber($state);
                                    $set('week_number', $nextWeek);

                                    $weekDetails = ProjectWeeklyReport::getWeekDetails($nextWeek);
                                    $set('title', $weekDetails['title'] ?? '');
                                    $set('focus', $weekDetails['focus'] ?? '');
                                }
                            }),

                        TextInput::make('week_number')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(4)
                            ->disabled()
                            ->dehydrated(),

                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(),

                        TextInput::make('focus')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2),

                Section::make('Checklist Pekerjaan')
                    ->schema([
                        CheckboxList::make('checklists')
                            ->options(function (callable $get) {
                                $weekNumber = $get('week_number');
                                return collect(ProjectWeeklyReport::getWeekChecklists($weekNumber))
                                    ->mapWithKeys(fn($item) => [$item => $item]);
                            })
                            ->required()
                            ->columns(1)
                            ->gridDirection('row'),
                    ]),

                Section::make('Dokumentasi & Bukti')
                    ->schema([
                        FileUpload::make('attachments')
                            ->multiple()
                            ->image()
                            ->directory('project-reports/weekly')
                            ->maxFiles(10)
                            ->maxSize(5120) // 5MB
                            ->label('Foto Dokumentasi')
                            ->helperText('Upload foto progress pekerjaan minggu ini')
                            ->columnSpanFull(),
                    ]),

                Section::make('Catatan Tambahan')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Catatan Minggu Ini')
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Weekly Reports')
            ->columns([
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
                    ->searchable(),

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
                    ->url(fn() => ProjectWeeklyReportResource::getUrl('create', [
                        'project_id' => $this->getOwnerRecord()->id
                    ]))
                    ->visible(fn() => $this->getOwnerRecord()->canStartWeek(
                        ProjectWeeklyReport::getNextWeekNumber($this->getOwnerRecord()->id)
                    )),
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
                Action::make('complete')
                    ->label('Mark Complete')
                    ->action(function (ProjectWeeklyReport $record) {
                        $record->update([
                            'is_completed' => true,
                            'completed_at' => now(),
                        ]);
                    })
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn(ProjectWeeklyReport $record) => !$record->is_completed),
            ])
            ->toolbarActions([
                // 
            ])
            ->defaultSort('week_number', 'asc');
    }
}
