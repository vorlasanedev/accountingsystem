<?php

namespace App\Filament\Resources\Accounts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AccountInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code'),
                TextEntry::make('name')
                    ->label('Account Name (English)'),
                TextEntry::make('lao_name')
                    ->label('ຊື່ບັນຊີ (ພາສາລາວ)'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('parent.name')
                    ->label('Parent Account')
                    ->placeholder('-'),
                IconEntry::make('is_active')
                    ->boolean()
                    ->label('Active'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
