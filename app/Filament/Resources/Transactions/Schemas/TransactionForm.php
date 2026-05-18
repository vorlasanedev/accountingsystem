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
                    ->label(app()->getLocale() === 'lo' ? 'ເລກອ້າງອີງ' : 'Reference Number')
                    ->required(),
                Select::make('type')
                    ->label(app()->getLocale() === 'lo' ? 'ປະເພດ' : 'Type')
                    ->options([
                        'Revenue' => app()->getLocale() === 'lo' ? 'ລາຍຮັບ' : 'Revenue',
                        'Expenditure' => app()->getLocale() === 'lo' ? 'ລາຍຈ່າຍ' : 'Expenditure'
                    ])
                    ->required(),
                Select::make('account_id')
                    ->label(app()->getLocale() === 'lo' ? 'ບັນຊີ' : 'Account')
                    ->relationship('account', app()->getLocale() === 'lo' ? 'lao_name' : 'name')
                    ->required(),
                Textarea::make('description')
                    ->label(app()->getLocale() === 'lo' ? 'ຄຳອະທິບາຍ' : 'Description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('total_amount')
                    ->label(app()->getLocale() === 'lo' ? 'ມູນຄ່າທັງໝົດ' : 'Total Amount')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->label(app()->getLocale() === 'lo' ? 'ສະຖານະ' : 'Status')
                    ->options([
                        'Draft' => app()->getLocale() === 'lo' ? 'ຮ່າງ' : 'Draft',
                        'Pending Review' => app()->getLocale() === 'lo' ? 'ລໍຖ້າກວດສອບ' : 'Pending review',
                        'Approved' => app()->getLocale() === 'lo' ? 'ອະນຸມັດ' : 'Approved',
                        'Rejected' => app()->getLocale() === 'lo' ? 'ປະຕິເສດ' : 'Rejected',
                    ])
                    ->default('Draft')
                    ->required()
                    ->disabledOn('create'),
                Select::make('created_by')
                    ->label(app()->getLocale() === 'lo' ? 'ຜູ້ສ້າງ' : 'Created By')
                    ->relationship('createdBy', 'name')
                    ->disabled(),
                Select::make('approved_by')
                    ->label(app()->getLocale() === 'lo' ? 'ຜູ້ອະນຸມັດ' : 'Approved By')
                    ->relationship('approvedBy', 'name')
                    ->disabled(),
                DateTimePicker::make('locked_at')
                    ->label(app()->getLocale() === 'lo' ? 'ວັນທີລັອກ' : 'Locked At')
                    ->disabled(),
            ]);
    }
}
