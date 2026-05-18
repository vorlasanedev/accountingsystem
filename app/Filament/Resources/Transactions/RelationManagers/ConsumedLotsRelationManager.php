<?php

namespace App\Filament\Resources\Transactions\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConsumedLotsRelationManager extends RelationManager
{
    protected static string $relationship = 'consumedLots';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reference_number')
                    ->required(),
                TextInput::make('description')
                    ->default(null),
                TextInput::make('requested_usd')
                    ->required()
                    ->numeric(),
                TextInput::make('exchange_rate')
                    ->required()
                    ->numeric(),
                TextInput::make('total_lak')
                    ->required()
                    ->numeric(),
                TextInput::make('remaining_lak')
                    ->required()
                    ->numeric(),
                DatePicker::make('date_requested')
                    ->required(),
                Toggle::make('is_exhausted')
                    ->required(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('reference_number'),
                TextEntry::make('description')
                    ->placeholder('-'),
                TextEntry::make('requested_usd')
                    ->numeric(),
                TextEntry::make('exchange_rate')
                    ->numeric(),
                TextEntry::make('total_lak')
                    ->numeric(),
                TextEntry::make('remaining_lak')
                    ->numeric(),
                TextEntry::make('date_requested')
                    ->date(),
                IconEntry::make('is_exhausted')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('reference_number')
            ->columns([
                TextColumn::make('reference_number')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('requested_usd')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('exchange_rate')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pivot.lak_consumed')
                    ->label('Consumed Amount')
                    ->numeric(0)
                    ->suffix(' LAK')
                    ->sortable(),
                TextColumn::make('remaining_lak')
                    ->numeric(0)
                    ->suffix(' LAK')
                    ->sortable(),
                TextColumn::make('date_requested')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_exhausted')
                    ->boolean()
                    ->label('Exhausted'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Read-only
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                // Read-only
            ]);
    }
}
