<?php

namespace App\Filament\Resources\Settings\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Name')
                    ->disabled(),

                TextEntry::make('email')
                    ->label('Email'),

                TextEntry::make('company.name')
                    ->label('Company')
                    ->disabled(),

                TextEntry::make('roles.name')
                    ->badge()
                    ->label('Roles')
                    ->disabled(),

                TextEntry::make('user_type')
                    ->label('User Type')
                    ->badge()
                    ->colors([
                        'success' => fn($state): bool => $state === 'internal',
                        'warning' => fn($state): bool => $state === 'external',
                    ])
                    ->disabled(),

                KeyValueEntry::make('employee')
                    ->label('Employee Data'),
            ])
            ->columns(1);
    }
}
