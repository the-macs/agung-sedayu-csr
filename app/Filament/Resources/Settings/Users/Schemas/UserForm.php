<?php

namespace App\Filament\Resources\Settings\Users\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('username')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->regex('/^[A-Za-z0-9.\-]+$/')
                    ->rule('min:3')
                    ->rule('max:30')
                    ->label('Username')
                    ->validationMessages([
                        'regex' => 'The username may only contain letters, numbers, dots, and dashes. ex. admin.123 or admin-123',
                    ]),

                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(20)
                    ->nullable(),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn (string $context) => $context === 'create')
                    ->dehydrateStateUsing(fn ($state) => ! empty($state) ? Hash::make($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->label('Password'),
            ]);
    }
}
