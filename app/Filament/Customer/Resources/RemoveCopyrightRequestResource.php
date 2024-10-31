<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\RemoveCopyrightRequestResource\Pages;
use App\Filament\Customer\Resources\RemoveCopyrightRequestResource\RelationManagers;
use App\Models\RemoveCopyrightRequest;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RemoveCopyrightRequestResource extends Resource
{
    protected static ?string $model = RemoveCopyrightRequest::class;

    protected static ?string $modelLabel = 'Release Copyright claim';

    protected static ?string $pluralModelLabel = 'Release Copyright claim';

    protected static ?string $navigationIcon = 'heroicon-o-play-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                TextInput::make('song_name')
                    ->required()
                    ->label('Song Name'),

                TextInput::make('yt_video_link')
                    ->activeUrl()
                    ->required()
                    ->label('YouTube Video Link'),

                Select::make('provider')
                ->label('Claim Provider')
                ->required()
                ->searchable()
                ->options([
                    '[Merlin] The New Digital Media' => '[Merlin] The New Digital Media',
                    '[Merlin] ABC Digital' => '[Merlin] ABC Digital',
                    'Believe Music' => 'Believe Music',
                    'The Orchard Music' => 'The Orchard Music',
                    'Unisys Music' => 'Unisys Music'
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where(['customer_id' => getCurrentCustomer()->id]))
            ->columns([
                TextColumn::make('song_name')
                    ->searchable()
                    ->sortable()
                    ->label('Song Name'),

                TextColumn::make('yt_video_link')
                    ->label('YouTube Video Link'),

                TextColumn::make('provider'),

                TextColumn::make('status')
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->badge(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => $record->status == 'pending'),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => $record->status == 'pending'),
            ])
            ->checkIfRecordIsSelectableUsing(fn ($record) => $record->status == 'pending')
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
            'index' => Pages\ListRemoveCopyrightRequests::route('/'),
            // 'create' => Pages\CreateRemoveCopyrightRequest::route('/create'),
            // 'edit' => Pages\EditRemoveCopyrightRequest::route('/{record}/edit'),
        ];
    }
}
