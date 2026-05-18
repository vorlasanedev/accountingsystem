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
                TextEntry::make('code')
                    ->label(__('Code')),
                TextEntry::make('name.' . app()->getLocale())
                    ->label(__('Account Name')),
                TextEntry::make('type')
                    ->label(__('Type'))
                    ->badge(),
                TextEntry::make('parent.name.' . app()->getLocale())
                    ->label(__('Parent Account'))
                    ->placeholder('-'),
                IconEntry::make('is_active')
                    ->boolean()
                    ->label(__('Active')),
                TextEntry::make('description')
                    ->label(__('Description'))
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
