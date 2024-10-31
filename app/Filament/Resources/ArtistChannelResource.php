<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ArtistChannel;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ArtistChannelResource\Pages;
use App\Filament\Resources\ArtistChannelResource\RelationManagers;
use Filament\Tables\Filters\SelectFilter;

class ArtistChannelResource extends Resource
{
    protected static ?string $model = ArtistChannel::class;

    protected static ?string $modelLabel = 'Artist Channel';

    protected static ?string $pluralModelLabel = 'Artist Channels';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Artist Name'),

                TextInput::make('topic_channel_link')
                    ->activeUrl()
                    ->required()
                    ->label('Artist Topic Channel Link'),

                TextInput::make('yt_channel_link')
                    ->activeUrl()
                    ->required()
                    ->label('Artist Official YouTube Channel Link'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Artist Name'),

                TextColumn::make('topic_channel_link')
                    ->color('info')
                    ->url(fn ($state) => $state ?? NULL, true)
                    ->placeholder('N/A')
                    ->label('Artist Topic Channel Link'),

                TextColumn::make('yt_channel_link')
                    ->color('info')
                    ->url(fn ($state) => $state ?? NULL, true)
                    ->placeholder('N/A')
                    ->label('Artist Official YouTube Channel Link'),

                TextColumn::make('customer.email')
                    ->sortable()
                    ->searchable()
                    ->label('Added By'),
                
                TextColumn::make('created_at')
                    ->sortable()
                    ->date('M d, Y')
                    ->label('Created At'),

                TextColumn::make('updated_at')
                    ->sortable()
                    ->date('M d, Y')
                    ->label('Updated At'),
            ])
            ->filters([
                SelectFilter::make('customer_id')
                    ->searchable()
                    ->relationship('customer', 'email')
                    ->preload()
                    ->label('Added By'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListArtistChannels::route('/'),
            // 'create' => Pages\CreateArtistChannel::route('/create'),
            // 'edit' => Pages\EditArtistChannel::route('/{record}/edit'),
        ];
    }
}
