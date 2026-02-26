<?php

namespace App\Filament\Resources\LoyaltyRewards;

use App\Filament\Resources\LoyaltyRewards\Pages\CreateLoyaltyReward;
use App\Filament\Resources\LoyaltyRewards\Pages\EditLoyaltyReward;
use App\Filament\Resources\LoyaltyRewards\Pages\ListLoyaltyRewards;
use App\Models\LoyaltyReward;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class LoyaltyRewardResource extends Resource
{
    protected static ?string $model = LoyaltyReward::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGift;

    protected static string|\UnitEnum|null $navigationGroup = 'Fidélité';

    protected static ?string $navigationLabel = 'Récompenses';

    protected static ?string $modelLabel = 'Récompense';

    protected static ?string $pluralModelLabel = 'Récompenses';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('team_id')
                ->relationship('team', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->label('Équipe'),
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->label('Nom'),
            TextInput::make('points_required')
                ->required()
                ->numeric()
                ->minValue(1)
                ->label('Points requis'),
            Select::make('icon')
                ->options([
                    'gift' => '🎁 Cadeau',
                    'star' => '⭐ Étoile',
                    'coffee' => '☕ Café',
                    'ticket' => '🎫 Ticket',
                    'percent' => '🏷️ Réduction',
                    'cake' => '🎂 Gâteau',
                    'burger' => '🍔 Burger',
                    'pizza' => '🍕 Pizza',
                    'drink' => '🥤 Boisson',
                    'icecream' => '🍦 Glace',
                    'scissors' => '✂️ Coiffure',
                    'massage' => '💆 Massage',
                    'car' => '🚗 Auto',
                    'bag' => '👜 Sac',
                    'money' => '💸 Argent',
                ])
                ->default('gift')
                ->label('Icône'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('team.name')
                    ->sortable()
                    ->searchable()
                    ->label('Équipe'),
                TextColumn::make('icon')
                    ->formatStateUsing(fn (string $state): string => [
                        'gift' => '🎁', 'star' => '⭐', 'coffee' => '☕', 'ticket' => '🎫',
                        'percent' => '🏷️', 'cake' => '🎂', 'burger' => '🍔', 'pizza' => '🍕',
                        'drink' => '🥤', 'icecream' => '🍦', 'scissors' => '✂️', 'massage' => '💆',
                        'car' => '🚗', 'bag' => '👜', 'money' => '💸',
                    ][$state] ?? '🎁')
                    ->label(''),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nom'),
                TextColumn::make('points_required')
                    ->numeric()
                    ->sortable()
                    ->label('Points requis'),
                TextColumn::make('deleted_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->label('Supprimé le')
                    ->placeholder('Actif')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->label('Créé le'),
            ])
            ->filters([
                SelectFilter::make('team_id')
                    ->relationship('team', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Équipe'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLoyaltyRewards::route('/'),
            'create' => CreateLoyaltyReward::route('/create'),
            'edit' => EditLoyaltyReward::route('/{record}/edit'),
        ];
    }
}
