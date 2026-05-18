<?php

namespace App\Filament\Resources\Lots\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LotsTable
{
    public static function configure(Table $table): Table
    {
        return $table
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
                TextColumn::make('total_lak')
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
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
