<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('submit_for_review')
                ->label('Submit for Review')
                ->color('warning')
                ->visible(fn () => $this->record->status === 'Draft')
                ->action(function () {
                    $this->record->update(['status' => 'Pending Review']);
                }),
            Action::make('approve')
                ->label('Approve & Lock')
                ->color('success')
                ->visible(fn () => $this->record->status === 'Pending Review')
                ->action(function () {
                    $this->record->update([
                        'status' => 'Approved',
                        'approved_by' => auth()->id(),
                        'locked_at' => now(),
                    ]);
                })
                ->requiresConfirmation(),
            ViewAction::make(),
            DeleteAction::make()
                ->hidden(fn () => $this->record->locked_at !== null),
        ];
    }
}
