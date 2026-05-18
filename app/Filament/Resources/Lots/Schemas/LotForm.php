<?php

namespace App\Filament\Resources\Lots\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LotForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reference_number')
                    ->required(),
                TextInput::make('description')
                    ->default(null),
                TextInput::make('requested_usd')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('exchange_rate')
                    ->required()
                    ->numeric()
                    ->default(22000),
                TextInput::make('total_lak')
                    ->disabled()
                    ->dehydrated(false)
                    ->numeric(),
                TextInput::make('remaining_lak')
                    ->disabled()
                    ->dehydrated(false)
                    ->numeric(),
                DatePicker::make('date_requested')
                    ->required()
                    ->default(now()),
                Toggle::make('is_exhausted')
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }
}
