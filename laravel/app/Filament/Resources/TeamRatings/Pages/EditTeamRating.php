<?php

namespace App\Filament\Resources\TeamRatings\Pages;

use App\Filament\Resources\TeamRatings\TeamRatingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeamRating extends EditRecord
{
    protected static string $resource = TeamRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
