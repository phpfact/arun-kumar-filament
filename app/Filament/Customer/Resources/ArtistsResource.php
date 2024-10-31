<?php

namespace App\Filament\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Artists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Customer\Resources\ArtistsResource\Pages;
use App\Filament\Customer\Resources\ArtistsResource\RelationManagers;

class ArtistsResource extends Resource
{
    protected static ?string $model = Artists::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                ->schema([
                    Forms\Components\FileUpload::make('profile')
                    ->label('Profile')
                    ->image()
                    ->required()
                    ->maxSize(20 * 1024)
                    ->disk('public')
                    ->directory('uploads/profile')
                    ->columnSpanFull(),

                    Forms\Components\TextInput::make('name')->label('Artists Name')->required(),
                    Forms\Components\TextInput::make('spotify_id')->label('Spotify ID'),
                    Forms\Components\TextInput::make('apple_id')->label('Apple ID'),
                    Forms\Components\TextInput::make('email')->email(),
                    Forms\Components\TextInput::make('instagram')->required(),
                    Forms\Components\TextInput::make('facebook')->required(),
                    Forms\Components\Textarea::make('about')->columnSpanFull(),
                ])->columns(3),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile')
                ->size(150)
                ->url(function($record){
                    return asset($record->profile);
                }),
                Tables\Columns\TextColumn::make('name')->label('Artists Name'),
                Tables\Columns\TextColumn::make('email'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListArtists::route('/'),
            'create' => Pages\CreateArtists::route('/create'),
            'edit' => Pages\EditArtists::route('/{record}/edit'),
        ];
    }
}
