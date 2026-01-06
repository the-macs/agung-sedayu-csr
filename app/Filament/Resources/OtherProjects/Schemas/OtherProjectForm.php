<?php

namespace App\Filament\Resources\OtherProjects\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas;

class OtherProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\Section::make('Project Information')
                    ->schema([
                        Forms\Components\TextInput::make('project_name')
                            ->label('Nama Proyek')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter project name'),

                        Forms\Components\TextInput::make('nama_lembaga')
                            ->label('Nama Lembaga')
                            ->maxLength(255)
                            ->placeholder('Enter organization name'),
                    ])->columns(2),

                Schemas\Components\Section::make('Contact Person')
                    ->schema([
                        Forms\Components\TextInput::make('penanggung_jawab')
                            ->label('Penanggung Jawab')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter person in charge name'),

                        Forms\Components\TextInput::make('no_whatsapp')
                            ->label('Nomor WhatsApp')
                            ->required()
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('e.g., +62812345678')
                            ->prefix('+')
                            ->telRegex('/^[0-9]{10,15}$/'),
                    ])->columns(2),

                Schemas\Components\Section::make('Location')
                    ->schema([
                        Forms\Components\Textarea::make('alamat_lengkap')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Enter complete address'),

                        Forms\Components\TextInput::make('link_google_maps')
                            ->label('Google Maps Link')
                            ->required()
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://maps.google.com/.. .')
                            ->suffixIcon('heroicon-o-map-pin')
                            ->columnSpanFull(),
                    ]),

                Schemas\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('photos')
                            ->label('Project Photos')
                            ->image()
                            ->multiple()
                            ->directory('project-photos')
                            ->maxFiles(5)
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
