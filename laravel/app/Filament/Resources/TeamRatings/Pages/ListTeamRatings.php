<?php

namespace App\Filament\Resources\TeamRatings\Pages;

use App\Filament\Resources\TeamRatings\TeamRatingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTeamRatings extends ListRecords
{
    protected static string $resource = TeamRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
