<?php

namespace App\Filament\Resources\Settings\Uoms\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique('uoms,name') // Ignore soft deleted records by default
                    ->label('Unit Name'),
                TextInput::make('abbreviation')
                    ->required()
                    ->maxLength(10)
                    ->unique('uoms,abbreviation')
                    ->label('Abbreviation'),
                Textarea::make('description')
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }
}
