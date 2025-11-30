<?php

namespace App\Filament\Resources\Settings\ItemMaterials\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ItemMaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('quantity')
                    ->required()
                    ->numeric(),

                Select::make('uom_id')
                    ->relationship('uom', 'name')
                    ->required()
                    ->native(false),

                Textarea::make('description')
                    ->rows(3)
                    ->maxLength(255),
            ]);
    }
}
