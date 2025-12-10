<?php

namespace App\Filament\Resources\ProjectMaterials\Schemas;

use Filament\Infolists;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectMaterialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Material Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Material Name'),

                        Infolists\Components\TextEntry::make('uom')
                            ->label('Unit of Measure'),

                        Infolists\Components\TextEntry::make('quantity')
                            ->label('Current Stock'),

                        Infolists\Components\TextEntry::make('project.nama_lengkap')
                            ->label('Project'),
                    ])
                    ->columns(2),
            ]);
    }
}
