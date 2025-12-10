<?php

namespace App\Filament\Resources\ProjectWeeklyReports\Schemas;

use App\Models\ProjectWeeklyReport;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProjectWeeklyReportForm
{
    public static function configure(Schema $schema): Schema
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

    public static function resolveRecord(): ?Model
    {
        $projectId = request()->query('project_id');

        if ($projectId) {
            return new ProjectWeeklyReport([
                'project_id' => $projectId,
                'week_number' => ProjectWeeklyReport::getNextWeekNumber($projectId),
                'reported_by' => Auth::id(),
            ]);
        }

        return null;
    }
}
