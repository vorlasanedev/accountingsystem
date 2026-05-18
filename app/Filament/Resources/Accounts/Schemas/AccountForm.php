<?php

namespace App\Filament\Resources\Accounts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('name')
                    ->label('Account Name (English)')
                    ->required(),
                TextInput::make('lao_name')
                    ->label('ຊື່ບັນຊີ (ພາສາລາວ)'),
                Select::make('type')
                    ->options([
                        'Asset' => 'Asset',
                        'Equity/Fund' => 'Equity/Fund',
                        'Control' => 'Control',
                        'Income' => 'Income',
                        'Expense' => 'Expense',
                        'Adjustment' => 'Adjustment',
                    ])
                    ->required(),
                Select::make('parent_id')
                    ->label('Parent Account')
                    ->relationship('parent', 'name')
                    ->placeholder('Select Parent Account (Optional)'),
                Toggle::make('is_active')
                    ->default(true)
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
