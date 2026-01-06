<?php

namespace App\Filament\Resources\Projects\RelationManagers;

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

class WeeklyReportsRelationManager extends RelationManager
{
    protected static string $relationship = 'weeklyReports';

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
                            ->maxValue(4)
                            ->default(function () {
                                return ProjectWeeklyReport::getNextWeekNumber(
                                    $this->getOwnerRecord()->id
                                );
                            })
                            ->disabled()
                            ->dehydrated(),

                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->default(function (callable $get) {
                                $weekNumber = $get('week_number');
                                if ($weekNumber) {
                                    $weekDetails = ProjectWeeklyReport::getWeekDetails($weekNumber);
                                    return $weekDetails['title'] ?? '';
                                }
                                return '';
                            })
                            ->disabled()
                            ->dehydrated(),

                        TextInput::make('focus')
                            ->required()
                            ->maxLength(255)
                            ->default(function (callable $get) {
                                $weekNumber = $get('week_number');
                                if ($weekNumber) {
                                    $weekDetails = ProjectWeeklyReport::getWeekDetails($weekNumber);
                                    return $weekDetails['focus'] ?? '';
                                }
                                return '';
                            })
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2),

                Section::make('Checklist Pekerjaan')
                    ->schema([
                        CheckboxList::make('checklists')
                            ->options(function (callable $get) {
                                $weekNumber = $get('week_number') ?? ProjectWeeklyReport::getNextWeekNumber(
                                    $this->getOwnerRecord()->id
                                );
                                return collect(ProjectWeeklyReport::getWeekChecklists($weekNumber))
                                    ->mapWithKeys(fn($item) => [$item => $item]);
                            })
                            ->required()
                            ->columns(1)
                            ->gridDirection('row'),
                    ]),

                Section::make('Dokumentasi & Bukti')
                    ->schema([
                        FileUpload::make('foto_tampak_depan')
                            ->required()
                            ->image()
                            ->directory('weekly_report/tampak-depan')
                            ->maxSize(2048)
                            ->label('Foto Tampak Depan')
                            ->helperText('Upload foto tampak depan rumah'),
                        FileUpload::make('foto_dalam_rumah')
                            ->required()
                            ->image()
                            ->directory('weekly_report/dalam-rumah')
                            ->maxSize(2048)
                            ->label('Foto Dalam Rumah')
                            ->helperText('Upload foto kondisi dalam rumah'),
                        FileUpload::make('foto_tampak_samping')
                            ->image()
                            ->directory('weekly_report/tampak-samping')
                            ->maxSize(2048)
                            ->label('Foto Tampak Samping')
                            ->helperText('Upload foto tampak samping rumah (opsional)'),
                        FileUpload::make('foto_toilet')
                            ->image()
                            ->directory('weekly_report/toilet')
                            ->maxSize(2048)
                            ->label('Foto Toilet')
                            ->helperText('Upload foto kondisi toilet (opsional)'),
                        FileUpload::make('foto_dapur')
                            ->image()
                            ->directory('weekly_report/dapur')
                            ->maxSize(2048)
                            ->label('Foto Dapur')
                            ->helperText('Upload foto kondisi dapur (opsional)'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

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
                    ->before(function (CreateAction $action) {
                        $action->fillForm([
                            'project_id' => $this->getOwnerRecord()->id,
                            'reported_by' => Auth::user()->id,
                        ]);
                    })
                    ->visible(fn() => $this->getOwnerRecord()->canStartWeek(
                        ProjectWeeklyReport::getNextWeekNumber($this->getOwnerRecord()->id)
                    ))
                    ->modalWidth('7xl'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->defaultSort('week_number', 'asc');
    }
}
