<?php

namespace App\Filament\Resources\Transactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_number')
                    ->label(app()->getLocale() === 'lo' ? 'ເລກອ້າງອີງ' : 'Reference Number')
                    ->searchable(),
                TextColumn::make('type')
                    ->label(app()->getLocale() === 'lo' ? 'ປະເພດ' : 'Type')
                    ->badge(),
                TextColumn::make(app()->getLocale() === 'lo' ? 'account.lao_name' : 'account.name')
                    ->label(app()->getLocale() === 'lo' ? 'ບັນຊີ' : 'Account')
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->label(app()->getLocale() === 'lo' ? 'ມູນຄ່າ' : 'Amount')
                    ->numeric(0)
                    ->suffix(' LAK')
                    ->sortable(),
                TextColumn::make('status')
                    ->label(app()->getLocale() === 'lo' ? 'ສະຖານະ' : 'Status')
                    ->badge(),
                TextColumn::make('createdBy.name')
                    ->label(app()->getLocale() === 'lo' ? 'ຜູ້ສ້າງ' : 'Created By')
                    ->sortable(),
                TextColumn::make('approvedBy.name')
                    ->label(app()->getLocale() === 'lo' ? 'ຜູ້ອະນຸມັດ' : 'Approved By')
                    ->sortable(),
                TextColumn::make('locked_at')
                    ->label(app()->getLocale() === 'lo' ? 'ວັນທີລັອກ' : 'Locked At')
                    ->dateTime()
                    ->sortable(),
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
