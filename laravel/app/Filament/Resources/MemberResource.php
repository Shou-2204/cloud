<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MemberResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Membres';

    protected static ?string $pluralLabel = 'Membres de l\'équipe';

    // IMPORTANT: On ne veut pas que cette ressource soit globale, mais scopée au tenant.
    // Filament gère ça automatiquement si le modèle (User) n'a PAS de relation directe simple avec le tenant
    // sauf que là User EST le membre.
    // En Filament Tenancy, pour gérer les membres, on utilise généralement une relation sur le tenant.
    // Mais ici on est dans le contexte d'un tenant.
    // Si on utilise `User::class`, Filament va essayer de lister TOUS les users si on ne fait pas attention.
    // Heureusement, avec `tenant(Team::class)`, les ressources sont scopées si elles ont une relation.
    // User a une relation `teams`.
    // Mais pour lister les membres DU tenant actuel, il faut configurer le query scope.

    // Pour simplifier, on va dire que cette ressource gère les membres VIA la relation team_user du tenant.
    // Mais c'est complexe à faire direct sur UserResource.
    // Une approche standard est de ne pas mettre UserResource en mode "tenant aware" par défaut sur la table users globale,
    // mais de le scoper manuellement.

    public static function getEloquentQuery(): Builder
    {
        // On retourne les users qui appartiennent à l'équipe courante
        $tenant = \Filament\Facades\Filament::getTenant();
        return parent::getEloquentQuery()->whereHas('teams', function ($query) use ($tenant) {
            $query->where('teams.id', $tenant->id);
        });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email(),
                // On peut ajouter la gestion du rôle via pivot ici si besoin, mais c'est plus complexe en form direct.
                // Pour l'instant, on affiche juste les infos.
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('teams.pivot.role')
                    ->label('Rôle')
                    ->state(function (User $record) {
                        $tenant = \Filament\Facades\Filament::getTenant();
                        $team = $record->teams->where('id', $tenant->id)->first();
                        return $team ? $team->pivot->role : '';
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('remove')
                    ->label('Retirer')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $tenant = \Filament\Facades\Filament::getTenant();
                        $tenant->members()->detach($record->id);
                    })
                    // On ne peut pas se retirer soi-même si on est owner, etc. (à affiner)
                    ->visible(fn (User $record) => $record->id !== auth()->id()),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
        ];
    }
}
