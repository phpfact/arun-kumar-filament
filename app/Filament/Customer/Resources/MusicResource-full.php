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

                                    /*
                                    FileUpload::make('album_cover_photo')
                                        ->columnSpanFull()
                                        ->label('Upload Cover')
                                        ->disk('public')
                                        ->directory('uploads/cover_photos')
                                        ->image()
                                        ->rules(['dimensions:width=3000,height=3000'])
                                        ->validationMessages([
                                            'dimensions' => 'Please upload 3000 x 3000 resolution image.',
                                            'max' => 'The cover photo must not be greater than 20 MB.'
                                        ])
                                        ->acceptedFileTypes(['image/jpeg'])
                                        ->maxSize(20 * 1024)
                                        ->required()
                                        ->helperText('Upload 3000 x 3000 pixels Size and Max 20MB.'),
                                    */

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

                                    Select::make('album_featuring_artists_id')
                                        ->label('Featuring')
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

                            /*
                            Section::make('Album Additional Details')
                                ->schema([

                                    Select::make('album_music_genre')
                                        ->label('Music Genre')
                                        ->searchable()
                                        ->required()
                                        ->options(MusicGenreList()),

                                    Select::make('album_music_sub_genre')
                                        ->label('Music Sub-Genre')
                                        ->searchable()
                                        ->required()
                                        ->options(MusicSubGenreList()),

                                    Select::make('album_label_id')
                                        ->label('Label Name')
                                        ->required()
                                        ->native(false)
                                        ->options(Label::where('customer_id', Auth::guard('customer')->user()->id)->where('status', '1')->pluck('title', 'id')),

                                    Select::make('album_release_type')
                                        ->label('Release Type')
                                        ->searchable()
                                        ->required()
                                        ->options([
                                            'single' => 'SINGLE',
                                            'ep' => 'EP',
                                            'album' => 'ALBUM',
                                        ]),

                                    DatePicker::make('album_release_date')->label('Release date')->required(),

                                    Select::make('album_production_year')
                                        ->label('Production Year')
                                        ->searchable()
                                        ->required()
                                        ->options(
                                            collect(range(2000, 2099))->mapWithKeys(function ($year) {
                                                return [$year => $year];
                                            })
                                        )
                                        ->default(date('Y'))
                                        ->required(),


                                    TextInput::make('album_upc_ean')->label('UPC/EAN'),

                                    TextInput::make('album_catalogue_number')->label('Catalogue number'),

                                    Select::make('album_music_mood')
                                        ->label('Music Mood')
                                        ->required()
                                        ->searchable()
                                        ->options(MusicMood()),

                                ])->columns(3),
                            */

                        ]),

                    Wizard\Step::make('Track')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('Review your basket 2')
                        ->schema([

                            Repeater::make('track')
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

                                            Select::make('featuring_artists_id')
                                                ->label('Featuring')
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

                                        /*
                                        Section::make('')
                                        ->schema([

                                            TagsInput::make('composer')->placeholder('')->required()->reorderable()->helperText('Digital Music Stores require full first and last (family) name'),

                                            TagsInput::make('producer')->placeholder('')->required()->reorderable(),

                                            Select::make('track_music_mood')
                                                ->label('Music Mood')
                                                ->required()
                                                ->searchable()
                                                ->options(MusicMood()),

                                        ])->columns(3),
                                        */

                                        /*
                                        Section::make('')
                                        ->schema([

                                            Select::make('track_music_genre')
                                                ->label('Music Genre')
                                                ->searchable()
                                                ->required()
                                                ->options(MusicGenreList()),

                                            Select::make('track_music_sub_genre')
                                                ->label('Music Sub-Genre')
                                                ->searchable()
                                                ->required()
                                                ->options(MusicSubGenreList()),

                                            Select::make('lyrics_language')
                                                ->label('Lyrics Languages')
                                                ->searchable()
                                                ->required()
                                                ->options(SongLanguages()),

                                        ])->columns(3),
                                        */

                                    /*
                                    Section::make('')
                                        ->schema([

                                            Radio::make('instrumental')->boolean()->inline()->inlineLabel(false)->options([
                                                'yes' => 'Yes',
                                                'no' => 'No',
                                            ])->descriptions([
                                                'yes' => 'Is not visible.',
                                                'no' => 'Will be visible.',
                                            ]),

                                            Radio::make('parental_advisory')
                                                ->label('Parental advisory')
                                                ->boolean()
                                                ->inline()
                                                ->inlineLabel(false)
                                                ->options([
                                                    'yes' => 'Yes',
                                                    'no' => 'No',
                                                    'cleaned' => 'Cleaned'
                                                ]),

                                            Radio::make('generate_an_isrc')
                                                ->label('Ask to generate an ISRC')
                                                ->boolean()
                                                ->inline()
                                                ->inlineLabel(false)
                                                ->options([
                                                    'yes' => 'Yes',
                                                    'no' => 'No',
                                                ])
                                                ->reactive()->default('yes'),

                                            TextInput::make('isrc')
                                                ->label('ISRC')
                                                ->columnSpanFull()
                                                ->required(fn(callable $get) => $get('generate_an_isrc') === 'no')
                                                ->placeholder('XX-0X0-00-00000')
                                                ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Please indicate the ISRC code of this track as detailed below:
                                                i.e.: GB-6V8-12-12340.
                                        
                                                An ISRC code is composed like this:
                                                GB : registrant country code
                                                6V8 : registrant code
                                                12 : year of registration
                                                1234 : 4 digits identifying the recording
                                                0 : "0" for audio, "1" for video
                                        
                                                This ISRC code is unique to a recording. When an ISRC code is generated for a track, it cannot be modified later.
                                                Failure to provide the correct unique ISRC to collective societies can lead to the impossibility to match your songs and collect revenue.')
                                                ->visible(fn(callable $get) => $get('generate_an_isrc') === 'no'),

                                        ])->columns(3),
                                        */

                                    /*
                                    Section::make('')
                                    ->schema([

                                        FileUpload::make('song_path')
                                        ->label('Upload Song')
                                        ->disk('public')
                                        ->directory('uploads/songs')
                                        ->acceptedFileTypes(['audio/x-wav', 'audio/wav', 'audio/mpeg'])
                                        ->rules(['mimes:application/octet-stream,mp3,wav'])
                                        ->validationMessages([
                                            'mimes' => 'Please upload only .mp3 or .wav file.',
                                            'max' => 'The song must not be greater than 200 MB.'
                                        ])
                                        ->maxSize(2000 * 1024)
                                        ->required()
                                        ->columnSpanFull()

                                    ])->columns(1)
                                    */

                                ])
                                // ->collapsed()
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

                    // Wizard\Step::make('Billing')
                    //     ->schema([
                    //         // ...
                    //     ]),

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

    public static function getRelations(): array
    {
        return [
            //
        ];
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
