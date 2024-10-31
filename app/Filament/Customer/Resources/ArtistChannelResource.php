<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\ArtistChannelResource\Pages;
use App\Filament\Customer\Resources\ArtistChannelResource\RelationManagers;
use App\Models\ArtistChannel;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
            ->modifyQueryUsing(fn ($query) => $query->where(['customer_id' => getCurrentCustomer()->id]))
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
