<?php

namespace App\Filament\Resources\Teams\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->label('ID')
                    ->default(fn () => \App\Models\Team::max('id') + 1)
                    ->disabled() // Generally safer to not let them edit it manually unless requested
                    ->dehydrated(false) // Let DB handle auto-increment unless we really want to force it. 
                    // Wait, if they want to "compléter" (fill), maybe they want to FORCE it? 
                    // Usually databases auto-increment. Showing it is informational. 
                    // If I put dehydrated(false), it won't be sent.
                    // If the user wants to *set* it, I should allow edit and send it. 
                    // But standard Eloquent create might ignore 'id' if distinct from auto-increment logic or fillable.
                    // safely: just display it.
                    ->visibleOn('create'),

                \Filament\Forms\Components\Select::make('user_id')
                    ->relationship('owner', 'email')
                    ->searchable()
                    ->required()
                    ->label('Owner'),
                
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                Toggle::make('personal_team')
                    ->default(false),

                // Read-only info fields
                TextInput::make('public_uuid')
                    ->disabled()
                    ->dehydrated(false) // Don't send to DB
                    ->visibleOn('edit'),
                    
                TextInput::make('join_code')
                    ->disabled()
                    ->visibleOn('edit'),
            ]);
    }
}
