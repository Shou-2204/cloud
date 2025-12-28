<?php

namespace App\Filament\Resources\TeamInvitationResource\Pages;

use App\Filament\Resources\TeamInvitationResource;
use App\Mail\TeamInvitationMail;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateTeamInvitation extends CreateRecord
{
    protected static string $resource = TeamInvitationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['team_id'] = \Filament\Facades\Filament::getTenant()->id;
        $data['token'] = Str::random(32); // Génération du token

        return $data;
    }

    protected function afterCreate(): void
    {
        // Envoi de l'email
        try {
            Mail::to($this->record->email)->send(new TeamInvitationMail($this->record));

            Notification::make()
                ->title('Invitation envoyée par email')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Erreur lors de l\'envoi de l\'email')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
