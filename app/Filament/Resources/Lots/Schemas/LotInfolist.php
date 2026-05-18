<?php

namespace App\Filament\Resources\Lots\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LotInfolist
{
    public static function configure(Schema $schema): Schema
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
}
