<?php

namespace App\Filament\Resources\ProjectMaterials\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class ProjectMaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'nama_lengkap')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('uom')
                    ->label('Unit of Measure')
                    ->required()
                    ->maxLength(50),

                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->minValue(0),
            ]);
    }
}
