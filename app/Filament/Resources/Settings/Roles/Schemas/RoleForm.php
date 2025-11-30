<?php

namespace App\Filament\Resources\Settings\Roles\Schemas;

use App\Models\Permission;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\CheckboxList;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Role Name')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                Select::make('guard_name')
                                    ->label('Guard Name')
                                    ->options([
                                        'web' => 'web',
                                        'api' => 'api',
                                    ])
                                    ->default('web')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        Section::make()
                            ->schema([
                                CheckboxList::make('permissions')
                                    ->options(function () {
                                        return once(function () {
                                            return Permission::query()
                                                ->orderBy('group')
                                                ->orderBy('name')
                                                ->get()
                                                ->mapWithKeys(function ($permission) {
                                                    $label = collect(explode('.', $permission->name))
                                                        ->map(fn($word) => ucfirst($word))
                                                        ->implode(' ');

                                                    return [$permission->id => $label];
                                                });
                                        });
                                    })
                                    ->descriptions(function () {
                                        return once(function () {
                                            return Permission::query()
                                                ->orderBy('group')
                                                ->orderBy('name')
                                                ->get()
                                                ->mapWithKeys(function ($permission) {
                                                    return [$permission->id => ucwords(str_replace('.', ' ', $permission->group))];
                                                });
                                        });
                                    })
                                    ->afterStateHydrated(fn($component, $record) => $record ? $component->state($record->permissions()->pluck('id')->toArray()) : null)
                                    ->searchable()
                                    ->columns(2)
                                    ->hiddenLabel()
                                    ->bulkToggleable()
                            ])
                            ->columnSpanFull()
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
