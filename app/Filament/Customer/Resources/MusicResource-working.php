<?php

namespace App\Filament\Customer\Resources;

use Filament\Forms;
use App\Models\Song;
use Filament\Tables;
use App\Models\Label;
use App\Models\Music;
use App\Models\Artists;
use App\Models\Release;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Customer\Resources\MusicResource\Pages;
use App\Filament\Customer\Resources\MusicResource\RelationManagers;

class MusicResource extends Resource
{
    protected static ?string $model = Release::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Wizard::make([
                    Wizard\Step::make('Release information')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('Review your basket')
                        ->schema([

                            Section::make('Album Details')
                                ->schema([

                                    TextInput::make('album_title')->required()->label('Album title'),

                                    Select::make('album_artists_id')
                                        ->label('Primary artist')
                                        ->required()
                                        ->native(false)
                                        ->multiple()
                                        ->options(Artists::where('customer_id', Auth::guard('customer')->user()->id)->pluck('name', 'id'))
                                        ->createOptionForm([
                                            Section::make('Create Artist')
                                                ->schema([
                                                    Forms\Components\FileUpload::make('profile')
                                                        ->label('Profile')
                                                        ->image()
                                                        ->required()
                                                        ->maxSize(20 * 1024)
                                                        ->disk('public')
                                                        ->directory('uploads/profile')
                                                        ->columnSpanFull(),

                                                    Forms\Components\Hidden::make('customer_id')->default(Auth::guard('customer')->user()->id),

                                                    Forms\Components\TextInput::make('name')->label('Artist Name')->required(),
                                                    Forms\Components\TextInput::make('spotify_id')->label('Spotify ID'),
                                                    Forms\Components\TextInput::make('apple_id')->label('Apple ID'),
                                                    Forms\Components\TextInput::make('email')->email(),
                                                    Forms\Components\TextInput::make('instagram')->required(),
                                                    Forms\Components\TextInput::make('facebook')->required(),
                                                    Forms\Components\Textarea::make('about')->columnSpanFull(),
                                                ])->columns(3),
                                        ])
                                        ->createOptionUsing(function ($data) {
                                            $artist = Artists::create($data);
                                            return $artist->id;
                                        }),

                                ])->columns(3),

                        ]),

                    Wizard\Step::make('Track')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('Review your basket 2')
                        ->schema([

                            Repeater::make('track')
                            // ->relationship()
                                ->label('')
                                ->schema([

                                    Section::make('')
                                        ->schema([

                                            TextInput::make('track_song_name')->columnSpanFull()->required()->label('Song title'),

                                            Select::make('artists_id')
                                                ->label('Primary artist')
                                                ->required()
                                                ->native(false)
                                                ->multiple()
                                                ->options(Artists::where('customer_id', Auth::guard('customer')->user()->id)->pluck('name', 'id'))
                                                ->createOptionForm([
                                                    Section::make('Create Artist')
                                                        ->schema([
                                                            Forms\Components\FileUpload::make('profile')
                                                                ->label('Profile')
                                                                ->image()
                                                                ->required()
                                                                ->maxSize(20 * 1024)
                                                                ->disk('public')
                                                                ->directory('uploads/profile')
                                                                ->columnSpanFull(),

                                                            Forms\Components\Hidden::make('customer_id')->default(Auth::guard('customer')->user()->id),

                                                            Forms\Components\TextInput::make('name')->label('Artist Name')->required(),
                                                            Forms\Components\TextInput::make('spotify_id')->label('Spotify ID'),
                                                            Forms\Components\TextInput::make('apple_id')->label('Apple ID'),
                                                            Forms\Components\TextInput::make('email')->email(),
                                                            Forms\Components\TextInput::make('instagram')->required(),
                                                            Forms\Components\TextInput::make('facebook')->required(),
                                                            Forms\Components\Textarea::make('about')->columnSpanFull(),
                                                        ])->columns(3),
                                                ])
                                                ->createOptionUsing(function ($data) {
                                                    $artist = Artists::create($data);
                                                    return $artist->id;
                                                }),

                                            TagsInput::make('authors')->placeholder('')->required()->reorderable()->helperText('Digital Music Stores require full first and last (family) name'),

                                        ])->columns(3),

                                ])
                                ->itemLabel(fn (array $state): ?string => $state['track_song_name'] ?? null)
                                ->addActionLabel('Add Track')
                                ->reorderable(true)
                                ->maxItems(function($get){
                                    if($get('album_release_type') == 'single'){
                                        return 1;
                                    }else if($get('album_release_type') == 'ep'){
                                        return 5;
                                    }else{
                                        return 100;
                                    }
                                })
                                ->reorderableWithButtons()
                                ->collapsible()
                                ->defaultItems(1)
                                ->columns(3),
                        ]),

                ])->columnSpanFull()
                ->skippable()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMusic::route('/'),
            'create' => Pages\CreateMusic::route('/create'),
            'edit' => Pages\EditMusic::route('/{record}/edit'),
        ];
    }
}
