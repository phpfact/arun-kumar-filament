<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Song;
use Filament\Tables;
use App\Models\Label;
use App\Models\Music;
use App\Models\Artists;
use App\Models\Release;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\MusicResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MusicResource\RelationManagers;

class MusicResource extends Resource
{
    protected static ?string $model = Release::class;

    protected static ?string $modelLabel = 'Audio Release';

    protected static ?string $pluralModelLabel = 'Audio Releases';

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('customer_id')
                    ->relationship('customer', 'email')
                    ->preload()
                    ->searchable()
                    ->live()
                    ->disabled(fn($operation) => $operation == 'edit')
                    ->afterStateUpdated(function($get, $set){
                        $set('album_artists_id', null);
                        // return null;
                    })
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return "{$record->first_name} {$record->last_name} ({$record->email})";
                    })
                    ->label('Customer Email'),

                Wizard::make([
                    Wizard\Step::make('Release information')
                        ->completedIcon('heroicon-m-musical-note')
                        ->description('information about your release.')
                        ->schema([

                            Section::make('Album Details')
                                ->schema([

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
                                        ->helperText('Upload 3000 x 3000 pixels Size and Max 20MB.')
                                        ->downloadable(),

                                    TextInput::make('album_title')->required()->label('Album title'),

                                    Select::make('album_artists_id')
                                        ->label('Primary artist')
                                        ->live()
                                        ->preload()
                                        ->required()
                                        ->native()
                                        ->multiple()
                                        // ->options(Artists::where('customer_id', Auth::guard('customer')->user()->id)->pluck('name', 'id'))
                                        ->relationship('release_primary_artist', 'name',
                                            modifyQueryUsing: fn (Builder $query, $get) => $query->where('customer_id', $get('customer_id')),
                                        )
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
                                                        ->columnSpanFull()
                                                        ->downloadable(),

                                                    Forms\Components\Hidden::make('customer_id')->default(fn($get) => $get('customer_id')),
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
                                        ->live()
                                        ->preload()
                                        // ->options(fn ($get) => Artists::where('customer_id', $get('customer_id'))->pluck('name', 'id'))
                                        ->relationship('artists', 'name',
                                            modifyQueryUsing: fn (Builder $query, $get) => $query->where('customer_id', $get('customer_id')),
                                        )
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
                                                        ->columnSpanFull()
                                                        ->downloadable(),

                                                    Forms\Components\Hidden::make('customer_id')->default(fn($get) => $get('customer_id')),
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
                                        ->options(fn($get) => Label::where('customer_id', $get('customer_id'))->where('status', '1')->pluck('title', 'id')),

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

                                Section::make('Album Additional Options')
                                ->schema([
                                    Toggle::make('stream_store')
                                    ->onColor('success')
                                    ->label('All Music Streaming Store'),

                                    Toggle::make('youtube_music')
                                        ->onColor('success')
                                        ->label('YouTube Music'),

                                    Toggle::make('yt_content_id')
                                        ->onColor('success')
                                        ->label('YouTube Content ID'),

                                ])->columns(3),

                        ]),

                    Wizard\Step::make('Track')
                        ->completedIcon('heroicon-m-musical-note')
                        ->description('You can add your track here.')
                        ->schema([

                            Repeater::make('tracks')
                                ->relationship()
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
                                                // ->options(Artists::where('customer_id', Auth::guard('customer')->user()->id)->pluck('name', 'id'))
                                                ->options(fn($get) => Artists::where('customer_id', $get('../../customer_id'))->pluck('name', 'id'))
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
                                                                ->columnSpanFull()
                                                                ->downloadable(),

                                                            Forms\Components\Hidden::make('customer_id')->default(fn($get) => $get('../../customer_id')),

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
                                                // ->options(Artists::where('customer_id', Auth::guard('customer')->user()->id)->pluck('name', 'id'))
                                                ->options(fn ($get) => Artists::where('customer_id', $get('../../customer_id'))->pluck('name', 'id'))
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
                                                                ->columnSpanFull()
                                                                ->downloadable(),

                                                            Forms\Components\Hidden::make('customer_id')->default(fn($get)=>$get('../../customer_id')),

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

                                    Section::make('')
                                        ->schema([

                                            Radio::make('instrumental')->boolean()->inline()->inlineLabel(false)->options([
                                                'yes' => 'Yes',
                                                'no' => 'No',
                                            ])->descriptions([
                                                'yes' => 'Is not visible.',
                                                'no' => 'Will be visible.',
                                            ])->default('yes'),

                                            Radio::make('parental_advisory')
                                                ->label('Parental advisory')
                                                ->boolean()
                                                ->inline()
                                                ->inlineLabel(false)
                                                ->options([
                                                    'yes' => 'Yes',
                                                    'no' => 'No',
                                                    'cleaned' => 'Cleaned'
                                                ])
                                                ->default('yes'),

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

                                    Section::make('')
                                    ->schema([

                                        Toggle::make('explicit')->onColor('success'),

                                        Select::make('instagram')
                                        ->label('Singer Instagram Handle')
                                        ->required()
                                        ->native(false)
                                        ->options(
                                            []
                                        ),

                                        Toggle::make('caller_tune')->live()->onColor('success')->label('Caller Tune'),

                                        Grid::make(2)->visible(fn ($get) => $get('caller_tune'))->schema([
                                            TagsInput::make('caller_tune_name')
                                                ->required()
                                                ->placeholder(NULL)
                                                ->label('Caller Tune Name'),

                                            TagsInput::make('caller_tune_duration')
                                                ->suffix('seconds')
                                                ->placeholder(NULL)
                                                ->required()
                                                ->label('Caller Tune Duration'),
                                        ]),

                                    ])->columns(3),

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
                                        ->downloadable()

                                    ])->columns(1)

                                ])
                                // ->collapsed()
                                ->itemLabel(fn (array $state): ?string => $state['track_song_name'] ?? null)
                                ->addActionLabel('Add One More Track')
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

                            Wizard\Step::make('Music Streaming Stores')
                            ->schema([
                                Section::make('')
                                    ->schema([
                                        TextInput::make('spotify_link')
                                            ->label('Spotify Link')
                                            ->url()
                                            ->placeholder('Enter Spotify Link'),

                                        TextInput::make('apple_music_link')
                                            ->label('Apple Music Link')
                                            ->url()
                                            ->placeholder('Enter Apple Music Link'),

                                        TextInput::make('gaana_link')
                                            ->label('Gaana Link')
                                            ->url()
                                            ->placeholder('Enter Gaana Link'),

                                        TextInput::make('jiosaavn_link')
                                            ->label('JioSaavn Link')
                                            ->url()
                                            ->placeholder('Enter JioSaavn Link'),

                                        TextInput::make('hungama_link')
                                            ->label('Hungama Link')
                                            ->url()
                                            ->placeholder('Enter Hungama Link'),

                                        TextInput::make('youtube_music_link')
                                            ->label('YouTube Music Link')
                                            ->url()
                                            ->placeholder('Enter YouTube Music Link'),

                                        TextInput::make('instagram_music_link')
                                            ->label('Instagram Music Link')
                                            ->url()
                                            ->placeholder('Enter Instagram Music Link'),

                                        TextInput::make('amazon_music_link')
                                            ->label('Amazon Music Link')
                                            ->url()
                                            ->placeholder('Enter Amazon Music Link'),

                                        TextInput::make('itunes_link')
                                            ->label('iTunes Link')
                                            ->url()
                                            ->placeholder('Enter iTunes Link'),

                                        TextInput::make('boomplay_link')
                                            ->label('Boomplay Link')
                                            ->url()
                                            ->placeholder('Enter Boomplay Link'),

                                            Section::make('')
                                            ->schema([

                                                Grid::make(2)
                                                ->schema([
                                                    TextInput::make('isrc_code')
                                                        ->label('ISRC Code'),

                                                    Select::make('status')
                                                        ->required()
                                                        ->live()
                                                        ->selectablePlaceholder(false)
                                                        ->options([
                                                            'pending' => 'Pending',
                                                            'approved' => 'Approved',
                                                            'rejected' => 'Rejected',
                                                        ]),

                                                    Textarea::make('reject_reason')
                                                        ->columnSpanFull()
                                                        ->required()
                                                        ->visible(fn ($get) => $get('status') == 'rejected')
                                                        ->label('Reject Reason'),
                                                ]),

                                            ]),

                                    ])
                                    ->columns(2) // Displays fields in two columns
                            ]),

                ])
                ->columnSpanFull()
                ->skippable()

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('album_cover_photo')->extraImgAttributes(['loading' => 'lazy'])->size(150)->toggleable()->label('Artwork')->openUrlInNewTab()
                ->url(function ($record) {
                    return asset($record->album_cover_photo);
                }),

                Tables\Columns\TextColumn::make('album_title')->searchable()->label('Album Name'),

                // Tables\Columns\TextColumn::make('artists.name')->searchable()->label('Artist Name'),
                Tables\Columns\TextColumn::make('release_primary_artist.name')->searchable()->label('Artist Name'),

                // Tables\Columns\TextColumn::make('track.title')->searchable()->label('Label Name'),

                Tables\Columns\TextColumn::make('album_label_id')->searchable()->formatStateUsing(function($record){
                    return Label::find($record->album_label_id)->title ?? '';
               })->label('Label Name'),

                Tables\Columns\TextColumn::make('album_upc_ean')->searchable()->label(' UPC/EAN'),

                Tables\Columns\TextColumn::make('isrc_code')->searchable()->label(' ISRC Code'),

                Tables\Columns\TextColumn::make('album_release_type')
                ->label('Release Type')
                ->formatStateUsing(fn ($state) => strtoupper($state))
                ->color(fn ($state) => match ($state) {
                    'single' => 'success',
                    'ep' => 'warning',
                    'album' => 'primary',
                    default => 'secondary',
                })
                ->icon(fn ($state) => match ($state) {
                    'single' => 'heroicon-o-musical-note',
                    'ep' => 'heroicon-o-square-3-stack-3d',
                    'album' => 'heroicon-o-archive-box',
                    default => 'heroicon-o-question-mark-circle',
                })
                ->badge()
                ->searchable(),

                Tables\Columns\TextColumn::make('album_catalogue_number')->label('Catalogue Number'),

                TextColumn::make('status')
                ->badge()
                ->searchable()
                ->color(fn ($state) => match ($state) {
                    'pending' => 'warning',
                    'approved' => 'success',
                    'rejected' => 'danger',
                })
                ->formatStateUsing(fn ($state) => ucfirst($state))
                ->tooltip(function (TextColumn $column, $record): ?string {
                    $state = $column->getState();

                    if ($state === 'rejected') {
                        return $record->reject_reason ?? 'No reason provided';
                    }

                    return null;
                }),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\ViewAction::make(),
            ])
            ->headerActions([
                // Tables\Actions\ExportAction::make()->exporter(\App\Filament\Exports\TrackExporter::class),
            ])
            ->bulkActions([
                BulkAction::make('Download CSV')
                    ->label('Download CSV')
                    ->icon('heroicon-o-arrow-down')
                    ->color('success')
                    ->action(function ($records) {

                        $ReleasedList = $records->pluck('id')->toArray();
                        self::handleCustomExport($ReleasedList);

                    })
            ]);
    }

    public static function handleCustomExport(array $selected): string
    {
      $rows = [];
        foreach ($selected as $key => $value) {

            $release = Release::where('id', $value)->with('tracks')->with('release_primary_artist')->with('artists')->first();
            if ($release) {

                $tracks         = $release->tracks;
                $artists        = $release->artists;
                $primary_artist = $release->release_primary_artist;

                //Loop on tracks
                foreach($tracks as $track){
                    $rows[] = [
                        'Album title'               => $release->album_title,
                        'Song title'                => $track->track_song_name,
                        'Primary artist'            => $primary_artist->pluck('name')->implode(', '),
                        'Featuring'                 => $artists->pluck('name')->implode(', '),
                        'Authors'                   => implode(', ', $track->authors),
                        'Composer'                  => implode(', ', $track->composer),
                        'Producer'                  => implode(', ', $track->producer),
                        'Singer Instagram Handle'   => $track->instagram,
                        'Label Name'                => @Label::find($release->album_label_id)->title ?? '',
                        'Lyrics Languages'          => $track->lyrics_language,
                        'Music Genre'               => ucwords(str_replace('_', ' ', $release->album_music_genre)),
                        'Music Sub-Genre'           => ucwords(str_replace('_', ' ', $release->album_music_sub_genre)),
                        'Music Mood'                => ucwords(str_replace('_', ' ', $track->track_music_mood)),
                        'Release date'              => $release->album_release_date,
                        'All Music Streaming Store' => $release->stream_store == 1 ? 'Yes' : 'No',
                        'YouTube Music'             => $release->youtube_music == 1 ? 'Yes' : 'No',
                        'YouTube Content ID'        => $release->yt_content_id == 1 ? 'Yes' : 'No',
                        'Explicit'                  => $track->explicit == 1 ? 'Yes' : 'No',
                        'Caller Tune'               => $track->caller_tune == 1 ? 'Yes' : 'No',
                        'Caller Tune Name'          => is_array($track->caller_tune_name) ? implode(', ', $track->caller_tune_name) : $track->caller_tune_name,
                        'Caller Tune Duration'      => is_array($track->caller_tune_duration) ? implode(', ', $track->caller_tune_duration) : $track->caller_tune_duration,
                        'Ask to generate an ISRC'   => ucwords($track->generate_an_isrc),
                        'ISRC Code'                 => $track->isrc,
                        'UPC/EAN'                   => $release->album_upc_ean,
                        'Catalogue number'          => $release->album_catalogue_number,
                        'Upload Cover'              => $release->album_cover_photo,
                        'Upload Song'               => $track->song_path,
                        'Status'                    => ucfirst($release->status),
                    ];

                }

            }

        }

        $uniqueId = Str::uuid()->toString(); // Generate a UUID for uniqueness
        $fileName = $uniqueId . '.csv';
        $filePath = public_path('releases_exports/' . $fileName);
        $file = fopen($filePath, 'w');

        // Add headers to the CSV file
        fputcsv($file, ['Album Title', 'Song title', 'Primary artist', 'Featuring', 'Authors', 'Composer', 'Producer', 'Singer Instagram Handle', 'Label Name', 'Lyrics Languages', 'Music Genre', 'Music Sub-Genre', 'Music Mood', 'Release date', 'All Music Streaming Store', 'YouTube Music', 'YouTube Content ID', 'Explicit', 'Caller Tune', 'Caller Tune Name', 'Caller Tune Duration', 'Ask to generate an ISRC', 'ISRC Code', 'UPC/EAN', 'Catalogue number', 'Upload Cover', 'Upload Song', 'Status']);

        // Write the rows to the CSV file
        foreach ($rows as $row) {
            fputcsv($file, $row);
        }

        // Close the file after writing
        fclose($file);

        // Return the file path for download
        $downloadUrl = asset('releases_exports/' . $fileName);
        Notification::make()->title("Release export is being processed...")->success()->duration(5000)->send();

        $recipient = auth()->user();
        $recipient->notify(
            Notification::make()
                ->title('Release Export')
                ->body('Your release export has been completed. Click the button below to download the CSV file. ' . "<a href='$downloadUrl' target='_blank' style='color:#FBBF24FF;font-weight:500;'><u>Download CSV</u></a>")
                ->toDatabase(),
        );

        return $downloadUrl;

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
            'view' => Pages\CreateMusic::route('/record'),
            'edit' => Pages\EditMusic::route('/{record}/edit'),
        ];
    }
}
