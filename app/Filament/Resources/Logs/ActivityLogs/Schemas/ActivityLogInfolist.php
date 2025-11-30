<?php

namespace App\Filament\Resources\Logs\ActivityLogs\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\KeyValueEntry;

class ActivityLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Activity Information')
                    ->schema([
                        TextEntry::make('log_name')->label('Module'),
                        TextEntry::make('event')->label('Action'),
                        TextEntry::make('causer.name')->label('User'),
                        TextEntry::make('subject_type')->label('Subject Type'),
                        TextEntry::make('subject_id')->label('Subject ID'),
                        TextEntry::make('created_at')->label('Created At'),
                    ])
                    ->columnSpan(3),

                Section::make('Changes')
                    ->schema([
                        KeyValueEntry::make('properties.attributes')
                            ->label('New Data')
                            ->visible(fn($record) => !empty($record->properties['attributes']))
                            ->getStateUsing(function ($record) {
                                $attributes = $record->properties['attributes'] ?? [];

                                if (!is_array($attributes)) {
                                    return $attributes;
                                }

                                return collect($attributes)->map(function ($value) {
                                    return is_array($value) ? json_encode($value) : $value;
                                })->toArray();
                            })
                            ->columnSpan(function ($record) {
                                return empty($record->properties['old']) ? 2 : 1;
                            }),

                        KeyValueEntry::make('properties.old')
                            ->label('Old Data')
                            ->hidden(fn($record) => empty($record->properties['old']))
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->columnSpan(9),
            ])
            ->columns(12);
    }
}
