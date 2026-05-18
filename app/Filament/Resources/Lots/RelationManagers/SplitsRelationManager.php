<?php

namespace App\Filament\Resources\Lots\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SplitsRelationManager extends RelationManager
{
    protected static string $relationship = 'splits';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('fund_source_id')
                    ->required()
                    ->numeric(),
                TextInput::make('allocated_usd')
                    ->required()
                    ->numeric(),
                TextInput::make('allocated_lak')
                    ->required()
                    ->numeric(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('fund_source_id')
                    ->numeric(),
                TextEntry::make('allocated_usd')
                    ->numeric(),
                TextEntry::make('allocated_lak')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('fundSource.name')
                    ->label('Fund Source')
                    ->sortable(),
                TextColumn::make('allocated_usd')
                    ->label('Allocated USD')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('allocated_lak')
                    ->label('Allocated LAK')
                    ->numeric(0)
                    ->suffix(' LAK')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Read-only: Splits are auto-generated
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                // Read-only
            ]);
    }
}
