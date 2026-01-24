<?php

namespace App\Filament\Resources\TeamRatings;

use App\Filament\Resources\TeamRatings\Pages\CreateTeamRating;
use App\Filament\Resources\TeamRatings\Pages\EditTeamRating;
use App\Filament\Resources\TeamRatings\Pages\ListTeamRatings;
use App\Filament\Resources\TeamRatings\Schemas\TeamRatingForm;
use App\Filament\Resources\TeamRatings\Tables\TeamRatingsTable;
use App\Models\TeamRating;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TeamRatingResource extends Resource
{
    protected static ?string $model = TeamRating::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return TeamRatingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeamRatingsTable::configure($table);
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
            'index' => ListTeamRatings::route('/'),
            'create' => CreateTeamRating::route('/create'),
            'edit' => EditTeamRating::route('/{record}/edit'),
        ];
    }
}
