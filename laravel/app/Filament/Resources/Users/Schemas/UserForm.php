<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->label('Numéro de téléphone')
                    ->tel()
                    ->rules(['nullable', 'phone:FR'])
                    ->maxLength(20),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Textarea::make('two_factor_secret')
                    ->columnSpanFull(),
                Textarea::make('two_factor_recovery_codes')
                    ->columnSpanFull(),
                DateTimePicker::make('two_factor_confirmed_at'),
                \Filament\Forms\Components\Select::make('current_team_id')
                    ->relationship('currentTeam', 'name')
                    ->searchable()
                    ->label('Current Team')
                    ->placeholder('Select a team'),
                TextInput::make('profile_photo_path'),
            ]);
    }
}
