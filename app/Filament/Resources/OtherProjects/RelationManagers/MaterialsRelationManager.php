<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Models\OtherProject;
use App\Models\ProjectMaterial;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'materials';

    protected static bool $canViewForRecord = true;

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->minValue(0)
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Material Relation')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('uom')
                    ->label('UOM')
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Current Stock')
                    ->sortable()
                    ->color(fn($record) => $record->quantity == 0 ? 'danger' : 'success'),

                // Total Stock In Column
                Tables\Columns\TextColumn::make('total_in')
                    ->label('Total In')
                    ->sortable()
                    ->getStateUsing(function (ProjectMaterial $record) {
                        return $record->transactions()
                            ->where('type', 'in')
                            ->where('status', 'approved')
                            ->sum('quantity');
                    })
                    ->numeric(),

                // Total Stock Out Column
                Tables\Columns\TextColumn::make('total_out')
                    ->label('Total Out')
                    ->sortable()
                    ->getStateUsing(function (ProjectMaterial $record) {
                        return $record->transactions()
                            ->where('type', 'out')
                            ->where('status', 'approved')
                            ->sum('quantity');
                    })
                    ->numeric(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Material')
                    ->after(function (CreateAction $action) {
                        $record = $action->getRecord();

                        if ($record->quantity > 0) {
                            $record->transactions()->create([
                                'quantity' => $record->quantity,
                                'type' => 'in',
                                'status' => 'approved',
                                'note' => 'Initial stock',
                                'request_by' => Auth::id(),
                                'approved_by' => Auth::id(),
                            ]);
                        }

                        Notification::make()
                            ->title('Material added successfully')
                            ->success()
                            ->send();
                    })
                    ->visible(fn() => $this->getOwnerRecord()->status === OtherProject::STATUS_ONGOING),
            ])
            ->recordActions([
                Action::make('stockIn')
                    ->label('Stock In')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->label('Quantity to Add'),

                        Forms\Components\Textarea::make('note')
                            ->label('Notes')
                            ->maxLength(500),
                    ])
                    ->action(function (array $data, ProjectMaterial $record): void {
                        // Create transaction
                        $record->transactions()->create([
                            'quantity' => $data['quantity'],
                            'type' => 'in',
                            'status' => 'approved', // Auto-approve for simplicity
                            'note' => $data['note'] ?? null,
                            'request_by' => Auth::id(),
                            'approved_by' => Auth::id(),
                        ]);

                        // Update material quantity
                        $record->increment('quantity', $data['quantity']);

                        Notification::make()
                            ->title('Stock added successfully')
                            ->success()
                            ->send();
                    }),

                // Stock Out Action  
                Action::make('stockOut')
                    ->label('Stock Out')
                    ->icon('heroicon-o-minus-circle')
                    ->color('danger')
                    ->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->label('Quantity to Remove')
                            ->rules([
                                function ($attribute, $record,  $value, $fail) {
                                    if ($value > $record->quantity) {
                                        $fail("Cannot remove more than current stock ({$record->quantity})");
                                    }
                                },
                            ]),

                        Forms\Components\Textarea::make('note')
                            ->label('Notes')
                            ->maxLength(500),
                    ])
                    ->action(function (array $data, ProjectMaterial $record): void {
                        // Create transaction
                        $record->transactions()->create([
                            'quantity' => $data['quantity'],
                            'type' => 'out',
                            'status' => 'approved', // Auto-approve for simplicity
                            'note' => $data['note'] ?? null,
                            'request_by' => Auth::id(),
                            'approved_by' => Auth::id(),
                        ]);

                        // Update material quantity
                        $record->decrement('quantity', $data['quantity']);

                        Notification::make()
                            ->title('Stock removed successfully')
                            ->success()
                            ->send();
                    }),
                Actions\Action::make('viewTransactions')
                    ->label('Transactions')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->modalHeading(fn($record) => "Transactions - {$record->name}")
                    ->modalContent(function ($record) {
                        Log::info($record);
                        $transactions = $record->transactions()
                            ->with(['requester', 'approver'])
                            ->latest()
                            ->paginate(10);

                        return view('filament.custom.other-project.transaction-table', [
                            'transactions' => $transactions,
                            'material' => $record,
                        ]);
                    })
                    ->modalSubmitAction(false)
                    ->modalWidth('7xl'),
            ])
            ->toolbarActions([
                // 
            ]);
    }
}
