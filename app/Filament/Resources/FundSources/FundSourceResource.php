<?php

namespace App\Filament\Resources\FundSources;

use App\Filament\Resources\FundSources\Pages\CreateFundSource;
use App\Filament\Resources\FundSources\Pages\EditFundSource;
use App\Filament\Resources\FundSources\Pages\ListFundSources;
use App\Filament\Resources\FundSources\Pages\ViewFundSource;
use App\Filament\Resources\FundSources\Schemas\FundSourceForm;
use App\Filament\Resources\FundSources\Schemas\FundSourceInfolist;
use App\Filament\Resources\FundSources\Tables\FundSourcesTable;
use App\Models\FundSource;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FundSourceResource extends Resource
{
    protected static ?string $model = FundSource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationLabel(): string
    {
        return __('Fund Sources');
    }

    public static function getModelLabel(): string
    {
        return __('Fund Source');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Fund Sources');
    }

    public static function form(Schema $schema): Schema
    {
        return FundSourceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FundSourceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FundSourcesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFundSources::route('/'),
            'create' => CreateFundSource::route('/create'),
            'view' => ViewFundSource::route('/{record}'),
            'edit' => EditFundSource::route('/{record}/edit'),
        ];
    }
}
