<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Team;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Créer une équipe';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nom de l\'équipe')
                    ->required(),
                TextInput::make('slug')
                    ->label('Identifiant (Slug)')
                    ->required()
                    ->unique(Team::class, 'slug'),
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $data['user_id'] = auth()->id();

        $team = Team::create($data);

        // Le créateur est automatiquement ajouté comme membre via la relation many-to-many
        // en plus d'être owner (user_id).
        $team->members()->attach(auth()->user(), ['role' => 'admin']);

        return $team;
    }
}
