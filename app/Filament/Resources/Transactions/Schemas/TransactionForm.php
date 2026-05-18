<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reference_number')
                    ->label(__('Reference Number'))
                    ->required(),
                Select::make('type')
                    ->label(__('Type'))
                    ->options([
                        'Revenue' => __('Revenue'),
                        'Expenditure' => __('Expenditure')
                    ])
                    ->required(),
                Select::make('account_id')
                    ->label(__('Account'))
                    ->relationship('account', app()->getLocale() === 'lo' ? 'lao_name' : 'name')
                    ->required(),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('total_amount')
                    ->label(__('Total Amount'))
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'Draft' => __('Draft'),
                        'Pending Review' => __('Pending review'),
                        'Approved' => __('Approved'),
                        'Rejected' => __('Rejected'),
                    ])
                    ->default('Draft')
                    ->required()
                    ->disabledOn('create'),
                Select::make('created_by')
                    ->label(__('Created By'))
                    ->relationship('createdBy', 'name')
                    ->disabled(),
                Select::make('approved_by')
                    ->label(__('Approved By'))
                    ->relationship('approvedBy', 'name')
                    ->disabled(),
                DateTimePicker::make('locked_at')
                    ->label(__('Locked At'))
                    ->disabled(),
            ]);
    }
}
