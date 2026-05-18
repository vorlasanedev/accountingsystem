<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class DonorExpenditureReport extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\FundSource::query())
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Donor Name')
                    ->weight('bold'),
                \Filament\Tables\Columns\TextColumn::make('initial_usd_balance')
                    ->label('Commitment USD')
                    ->money('USD'),
                \Filament\Tables\Columns\TextColumn::make('available_usd_balance')
                    ->label('Available USD')
                    ->money('USD'),
                \Filament\Tables\Columns\TextColumn::make('allocated_lak')
                    ->label('Allocated LAK (Lots)')
                    ->getStateUsing(fn ($record) => $record->lotSplits()->sum('allocated_lak'))
                    ->numeric(0)
                    ->suffix(' LAK'),
                \Filament\Tables\Columns\TextColumn::make('spent_lak')
                    ->label('Spent LAK')
                    ->getStateUsing(fn ($record) => $record->spent_lak)
                    ->numeric(0)
                    ->suffix(' LAK'),
                \Filament\Tables\Columns\TextColumn::make('spent_usd')
                    ->label('Spent USD')
                    ->getStateUsing(fn ($record) => $record->spent_usd)
                    ->money('USD'),
            ])
            ->filters([
                //
            ]);
    }
}
