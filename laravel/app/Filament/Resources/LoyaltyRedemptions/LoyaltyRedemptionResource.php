<?php

namespace App\Filament\Resources\LoyaltyRedemptions;

use App\Filament\Resources\LoyaltyRedemptions\Pages\CreateLoyaltyRedemption;
use App\Filament\Resources\LoyaltyRedemptions\Pages\EditLoyaltyRedemption;
use App\Filament\Resources\LoyaltyRedemptions\Pages\ListLoyaltyRedemptions;
use App\Models\LoyaltyRedemption;
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

class LoyaltyRedemptionResource extends Resource
{
    protected static ?string $model = LoyaltyRedemption::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|\UnitEnum|null $navigationGroup = 'Fidélité';

    protected static ?string $navigationLabel = 'Consommations';

    protected static ?string $modelLabel = 'Consommation';

    protected static ?string $pluralModelLabel = 'Consommations';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('team_id')
                ->relationship('team', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->label('Équipe'),
            Select::make('crm_contact_id')
                ->relationship('contact', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->label('Client'),
            Select::make('loyalty_reward_id')
                ->relationship('reward', 'name')
                ->searchable()
                ->preload()
                ->nullable()
                ->label('Récompense'),
            TextInput::make('reward_name')
                ->label('Nom de la récompense (snapshot)')
                ->maxLength(255),
            TextInput::make('points_spent')
                ->required()
                ->numeric()
                ->minValue(1)
                ->label('Points dépensés'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('UUID')
                    ->limit(8)
                    ->tooltip(fn ($record) => $record->id)
                    ->copyable()
                    ->sortable(),
                TextColumn::make('team.name')
                    ->sortable()
                    ->searchable()
                    ->label('Équipe'),
                TextColumn::make('contact.name')
                    ->sortable()
                    ->searchable()
                    ->label('Client'),
                TextColumn::make('reward_name')
                    ->searchable()
                    ->label('Récompense')
                    ->placeholder('—'),
                TextColumn::make('points_spent')
                    ->numeric()
                    ->sortable()
                    ->label('Points'),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->label('Date'),
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
            'index' => ListLoyaltyRedemptions::route('/'),
            'create' => CreateLoyaltyRedemption::route('/create'),
            'edit' => EditLoyaltyRedemption::route('/{record}/edit'),
        ];
    }
}
