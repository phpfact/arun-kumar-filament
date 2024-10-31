<?php

namespace App\Filament\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Label;
use App\Models\Artists;
use Filament\Forms\Form;
use App\Models\VideoSong;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Customer\Resources\VideoSongResource\Pages;
use App\Filament\Customer\Resources\VideoSongResource\RelationManagers;

class VideoSongResource extends Resource
{
    protected static ?string $model = VideoSong::class;

    protected static ?string $modelLabel = 'Video Song';

    protected static ?string $pluralModelLabel = 'Video Songs';

    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('')
                ->schema([

                    TextInput::make('title')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->label('Video Title'),

                    Select::make('artists_id')
                        ->label('Artists')
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

                    TagsInput::make('publisher')->placeholder('')->label('Lyricists Name')->required(),

                    TagsInput::make('composer')
                        ->placeholder(NULL)
                        ->required()
                        ->label('Music/Composer'),

                    TagsInput::make('produser_name')->placeholder('')->required(),

                    Select::make('label_id')
                        ->label('Label')
                        ->required()
                        ->native(false)
                        ->options(Label::where('customer_id', Auth::guard('customer')->user()->id)->where('status', '1')->pluck('title', 'id')),

                ])->columns(3),

                Section::make('')
                ->schema([

                    // TextInput::make('instagram')->label('Singer Instagram Handle'),

                    Select::make('instagram')
                    ->label('Singer Instagram Handle')
                    ->required()
                    ->native(false)
                    ->options(
                        Artists::where('customer_id', Auth::guard('customer')->user()->id)->get()->mapWithKeys(function ($artist) {
                            return [
                                $artist->instagram => $artist->instagram . ' - (' . $artist->name . ')',
                            ];
                        })
                    ),

                    DatePicker::make('release_date')
                    ->required()
                    ->label('Song Release Date'),

                    Select::make('languages')
                    ->label('Song Languages')
                    ->searchable()
                    ->required()
                    ->options([
                        'hindi' => 'Hindi',
                        'english' => 'English',
                        'punjabi' => 'Punjabi',
                        'bengali' => 'Bengali',
                        'tamil' => 'Tamil',
                        'telugu' => 'Telugu',
                        'marathi' => 'Marathi',
                        'gujarati' => 'Gujarati',
                        'malayalam' => 'Malayalam',
                        'kannada' => 'Kannada',
                        'odia' => 'Odia',
                        'assamese' => 'Assamese',
                        'sanskrit' => 'Sanskrit',
                        'dogri' => 'Dogri',
                        'konkani' => 'Konkani',
                        'sindhi' => 'Sindhi',
                        'manipuri' => 'Manipuri',
                        'bodo' => 'Bodo',
                        'santali' => 'Santali',
                        'kashmiri' => 'Kashmiri',
                        'maithili' => 'Maithili',
                        'nepali' => 'Nepali',
                        'rajbanshi' => 'Rajbanshi',
                        'bhili' => 'Bhili',
                        'chhattisgarhi' => 'Chhattisgarhi',
                        'magahi' => 'Magahi',
                        'rajasthani' => 'Rajasthani',
                        'marwari' => 'Marwari',
                        'haryanvi' => 'Haryanvi',
                        'angika' => 'Angika',
                        'khasi' => 'Khasi',
                        'mizo' => 'Mizo',
                        'bishnupriya manipuri' => 'Bishnupriya Manipuri',
                        'tulu' => 'Tulu',
                        'halbi' => 'Halbi',
                        'garhwali' => 'Garhwali',
                        'kokborok' => 'Kokborok',
                        'sourashtra' => 'Sourashtra',
                        'gadaba' => 'Gadaba',
                        'bhutia' => 'Bhutia',
                        'ao' => 'Ao',
                        'deori' => 'Deori',
                        'gangte' => 'Gangte',
                        'ghotuo' => 'Ghotuo',
                        'gondi' => 'Gondi',
                        'gujjar bhakha' => 'Gujjar Bhakha',
                        'ho' => 'Ho',
                        'juang' => 'Juang',
                        'kannada kuri' => 'Kannada Kuri',
                        'karbi' => 'Karbi',
                        'kashmiri pahari' => 'Kashmiri Pahari',
                        'khampti' => 'Khampti',
                        'khamyang' => 'Khamyang',
                        'khortha' => 'Khortha',
                        'kodava' => 'Kodava',
                        'kui' => 'Kui',
                        'kurukh' => 'Kurukh',
                        'ladakhi' => 'Ladakhi',
                        'lamkang' => 'Lamkang',
                        'lepcha' => 'Lepcha',
                        'lotha' => 'Lotha',
                        'mara' => 'Mara',
                        'mishing' => 'Mishing',
                        'mohpa' => 'Mohpa',
                        'mru' => 'Mru',
                        'nocte' => 'Nocte',
                        'nyishi' => 'Nyishi',
                        'pangchenpa' => 'Pangchenpa',
                        'patelia' => 'Patelia',
                        'rengma' => 'Rengma',
                        'saraiki' => 'Saraiki',
                        'sherpa' => 'Sherpa',
                        'shina' => 'Shina',
                        'singpho' => 'Singpho',
                        'thado' => 'Thado',
                        'thoibi' => 'Thoibi',
                        'thulung' => 'Thulung',
                        'tikhak' => 'Tikhak',
                        'tongsa' => 'Tongsa',
                        'wancho' => 'Wancho',
                        'zeliangrong' => 'Zeliangrong',
                        'zeme' => 'Zeme',
                        'badaga' => 'Badaga',
                        'bagheli' => 'Bagheli',
                        'bagri' => 'Bagri',
                        'barela' => 'Barela',
                        'barma' => 'Barma',
                        'bateri' => 'Bateri',
                        'beary' => 'Beary',
                        'bhilodi' => 'Bhilodi',
                        'burushaski' => 'Burushaski',
                        'dungra bhil' => 'Dungra Bhil',
                        'dura' => 'Dura',
                        'gadwali' => 'Gadwali',
                        'gaddi' => 'Gaddi',
                        'galatga' => 'Galatga',
                        'gamit' => 'Gamit',
                        'garasia' => 'Garasia',
                        'gowlan' => 'Gowlan',
                        'gowlan jantri' => 'Gowlan Jantri',
                        'kathiyawadi' => 'Kathiyawadi',
                        'kho' => 'Kho',
                        'koli' => 'Koli',
                        'kumaoni' => 'Kumaoni',
                        'malto' => 'Malto',
                        'mavchi' => 'Mavchi',
                        'meena' => 'Meena',
                        'muria' => 'Muria',
                        'pali' => 'Pali',
                        'pardhi' => 'Pardhi',
                        'rangkas' => 'Rangkas',
                        'riang' => 'Riang',
                        'sambalpuri' => 'Sambalpuri',
                        'seka' => 'Seka',
                        'sholaga' => 'Sholaga',
                        'sirha' => 'Sirha',
                        'thakuri' => 'Thakuri',
                        'tirunelveli' => 'Tirunelveli',
                        'toda' => 'Toda',
                        'vaalipora' => 'Vaalipora',
                        'valvi' => 'Valvi',
                        'vasava' => 'Vasava',
                        'dogri' => 'Dogri',
                        'konkani' => 'Konkani',
                        'sindhi' => 'Sindhi',
                        'manipuri' => 'Manipuri',
                        'bodo' => 'Bodo',
                        'santali' => 'Santali',
                        'kashmiri' => 'Kashmiri',
                        'maithili' => 'Maithili',
                    ]),
                
                Select::make('music_genre')
                    ->label('Music Genre')
                    ->searchable()
                    ->required()
                    ->options([
                        'bollywood' => 'Bollywood',
                        'classical' => 'Classical',
                        'bhajan' => 'Bhajan',
                        'ghazal' => 'Ghazal',
                        'pop' => 'Pop',
                        'folk' => 'Folk',
                        'punjabi' => 'Punjabi',
                        'rock' => 'Rock',
                        'hip_hop' => 'Hip Hop',
                        'sufi' => 'Sufi',
                        'indie' => 'Indie',
                        'devotional' => 'Devotional',
                        'trance' => 'Trance',
                        'reggae' => 'Reggae',
                        'jazz' => 'Jazz',
                        'metal' => 'Metal',
                        'rnb' => 'R&B',
                        'dance' => 'Dance',
                        'house' => 'House',
                        'electronic' => 'Electronic',
                        'pop_folk' => 'Pop-Folk',
                        'rock' => 'Rock',
                        'pop' => 'Pop',
                        'hip_hop' => 'Hip Hop',
                        'jazz' => 'Jazz',
                        'blues' => 'Blues',
                        'country' => 'Country',
                        'reggae' => 'Reggae',
                        'electronic' => 'Electronic',
                        'dance' => 'Dance',
                        'metal' => 'Metal',
                        'classical' => 'Classical',
                        'soul' => 'Soul',
                        'rnb' => 'R&B',
                        'salsa' => 'Salsa',
                        'funk' => 'Funk',
                        'disco' => 'Disco',
                        'grunge' => 'Grunge',
                        'punk' => 'Punk',
                        'alternative' => 'Alternative',
                        'indie' => 'Indie',
                        'gospel' => 'Gospel',
                        'trap' => 'Trap',
                        'kpop' => 'K-Pop',
                        'celtic' => 'Celtic',
                        'opera' => 'Opera',
                        'world' => 'World',
                        'ambient' => 'Ambient',
                        'lofi' => 'Lo-fi',
                        'new_age' => 'New Age',
                        'swing' => 'Swing',
                        'bossa_nova' => 'Bossa Nova',
                        'bluegrass' => 'Bluegrass',
                        'heavy_metal' => 'Heavy Metal',
                        'industrial' => 'Industrial',
                        'soundtrack' => 'Soundtrack',
                        'children' => 'Children\'s Music',
                        'mariachi' => 'Mariachi',
                        'chanson' => 'Chanson',
                        'cumbia' => 'Cumbia',
                        'merengue' => 'Merengue',
                        'tango' => 'Tango',
                        'skank' => 'Skank',
                        'afrobeat' => 'Afrobeat',
                        'highlife' => 'Highlife',
                        'soukous' => 'Soukous',
                        'mambo' => 'Mambo',
                        'bhangra' => 'Bhangra',
                        'trot' => 'Trot',
                        'zouk' => 'Zouk',
                        'dubstep' => 'Dubstep',
                        'progressive_house' => 'Progressive House',
                        'deep_house' => 'Deep House',
                        'techno' => 'Techno',
                        'trance' => 'Trance',
                        'hardstyle' => 'Hardstyle',
                        'big_room' => 'Big Room',
                        'future_bass' => 'Future Bass',
                    ]),

                    Select::make('music_sub_genre')
                        ->label('Music Sub-Genre')
                        ->searchable()
                        ->required()
                        ->options([
                            // Sub-genres of Bollywood
                            'bollywood_pop' => 'Bollywood Pop',
                            'bollywood_classical' => 'Bollywood Classical',
                            'bollywood_rock' => 'Bollywood Rock',
                            'bollywood_folk' => 'Bollywood Folk',

                            // Sub-genres of Classical
                            'hindustani' => 'Hindustani',
                            'carnatic' => 'Carnatic',
                            'baroque' => 'Baroque',
                            'romantic' => 'Romantic',

                            // Sub-genres of Rock
                            'classic_rock' => 'Classic Rock',
                            'hard_rock' => 'Hard Rock',
                            'alternative_rock' => 'Alternative Rock',
                            'punk_rock' => 'Punk Rock',
                            'indie_rock' => 'Indie Rock',

                            // Sub-genres of Pop
                            'dance_pop' => 'Dance Pop',
                            'synthpop' => 'Synthpop',
                            'bubblegum_pop' => 'Bubblegum Pop',
                            'teen_pop' => 'Teen Pop',

                            // Sub-genres of Hip Hop
                            'gangsta_rap' => 'Gangsta Rap',
                            'trap' => 'Trap',
                            'boom_bap' => 'Boom Bap',
                            'conscious_rap' => 'Conscious Rap',

                            // Sub-genres of Jazz
                            'smooth_jazz' => 'Smooth Jazz',
                            'bebop' => 'Bebop',
                            'swing' => 'Swing',
                            'free_jazz' => 'Free Jazz',

                            // Sub-genres of Folk
                            'traditional_folk' => 'Traditional Folk',
                            'contemporary_folk' => 'Contemporary Folk',
                            'bluegrass' => 'Bluegrass',

                            // Sub-genres of Electronic
                            'house' => 'House',
                            'techno' => 'Techno',
                            'dubstep' => 'Dubstep',
                            'drum_and_bass' => 'Drum and Bass',

                            // Sub-genres of Reggae
                            'roots_reggae' => 'Roots Reggae',
                            'dancehall' => 'Dancehall',
                            'dub' => 'Dub',

                            // Sub-genres of Metal
                            'heavy_metal' => 'Heavy Metal',
                            'death_metal' => 'Death Metal',
                            'black_metal' => 'Black Metal',
                            'power_metal' => 'Power Metal',

                            // Sub-genres of Country
                            'country_rock' => 'Country Rock',
                            'bluegrass' => 'Bluegrass',
                            'outlaw_country' => 'Outlaw Country',

                            // Sub-genres of Soul/R&B
                            'neo_soul' => 'Neo Soul',
                            'classic_soul' => 'Classic Soul',
                            'funk' => 'Funk',

                            // Sub-genres of Indie
                            'indie_pop' => 'Indie Pop',
                            'indie_folk' => 'Indie Folk',
                            'indie_rock' => 'Indie Rock',

                            // Sub-genres of World Music
                            'afrobeat' => 'Afrobeat',
                            'cumbia' => 'Cumbia',
                            'bhangra' => 'Bhangra',
                            'tango' => 'Tango',

                            // Other sub-genres
                            'lofi' => 'Lo-fi',
                            'new_age' => 'New Age',
                            'gospel' => 'Gospel',
                            'swing' => 'Swing',
                            'bossa_nova' => 'Bossa Nova',
                        ]),

                        Select::make('music_mood')
                            ->label('Music Mood')
                            ->required()
                            ->searchable()
                            ->options([
                                'happy' => 'Happy',
                                'sad' => 'Sad',
                                'relaxed' => 'Relaxed',
                                'energetic' => 'Energetic',
                                'melancholic' => 'Melancholic',
                                'uplifting' => 'Uplifting',
                                'romantic' => 'Romantic',
                                'nostalgic' => 'Nostalgic',
                                'calm' => 'Calm',
                                'intense' => 'Intense',
                                'mysterious' => 'Mysterious',
                                'joyful' => 'Joyful',
                                'chill' => 'Chill',
                                'motivational' => 'Motivational',
                                'dark' => 'Dark',
                                'playful' => 'Playful',
                                'reflective' => 'Reflective',
                                'dreamy' => 'Dreamy',
                                'passionate' => 'Passionate',
                                'soothing' => 'Soothing',
                                'aggressive' => 'Aggressive',
                                'festive' => 'Festive',
                                'serene' => 'Serene',
                                'adventurous' => 'Adventurous',
                                'dramatic' => 'Dramatic',
                                'haunting' => 'Haunting',
                                'spiritual' => 'Spiritual',
                                'uplifting' => 'Uplifting',
                                'bittersweet' => 'Bittersweet',
                                'hopeful' => 'Hopeful',
                                'angry' => 'Angry',
                                'silly' => 'Silly',
                                'introspective' => 'Introspective',
                                'whimsical' => 'Whimsical',
                                'romantic' => 'Romantic',
                                'mellow' => 'Mellow',
                                'heartwarming' => 'Heartwarming',
                                'suspenseful' => 'Suspenseful',
                            ])

                ])->columns(3),

                Section::make('')
                ->schema([

                    Grid::make(2)
                    ->schema([
                        FileUpload::make('cover_photo')
                        ->label('Upload Cover Photo')
                        ->disk('public')
                        ->directory('uploads/video_cover_photos')
                        ->image()
                        ->rules(['dimensions:width=1920,height=1080'])
                        ->validationMessages([
                            'dimensions' => 'Please upload a 1920 x 1080 resolution image.',
                            'max' => 'The cover photo must not be greater than 20 MB.'
                        ])
                        ->acceptedFileTypes(['image/jpeg'])
                        ->maxSize(20 * 1024)
                        ->required(),

                        FileUpload::make('video_path')
                            ->label('Upload Video')
                            ->disk('public')
                            ->directory('uploads/video_songs')
                            ->acceptedFileTypes(['video/mp4'])
                            ->validationMessages([
                                'max' => 'The video not be greater than 1 GB.'
                            ])
                            ->maxSize(1024 * 1024 * 1024)
                            ->required(),

                    ]),

                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where(['customer_id' => getCurrentCustomer()->id]))
            ->columns([
                ImageColumn::make('cover_photo')
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->size(150)
                    ->toggleable()
                    ->label('Art Work')
                    ->url(function ($record) {
                        return asset($record->cover_photo);
                    })
                    ->openUrlInNewTab(),

                TextColumn::make('title')
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->label('Video Title'),

                TextColumn::make('label.title')->placeholder('N/A')
                ->toggleable()
                ->label('Label Name'),

                TextColumn::make('artists_id')
                ->label('Artists Name')
                ->placeholder('N/A')
                ->toggleable()
                ->formatStateUsing(function ($record) {
                    $badges = [];
                    foreach ($record->artists_id as $id) {
                        $artist = Artists::find($id);
                        if ($artist) {
                            $badges[] = '<span style="display: inline-block; padding: 1px 10px; background-color: #FFEB3B17; color: #FDD835; border: 1px solid #FDD835; border-radius: 12px; font-size: 0.700rem; font-weight: 500; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); margin-right: 6px;">' . e($artist->name) . '</span>';
                        }
                    }
                    return implode(' ', $badges);
                })
                ->html(),

                // TextColumn::make('singers')
                //     ->toggleable()
                //     ->badge()
                //     ->label('Singers'),

                // TextColumn::make('lyrics')
                //     ->toggleable()
                //     ->badge()
                //     ->label('Lyrics/Composition'),

                TextColumn::make('composer')
                    ->toggleable()
                    ->badge()
                    ->label('Music/Composer'),

                    TextColumn::make('publisher')
                    ->toggleable()
                    ->badge()
                    ->label('Lyricists Name'),

                // TextColumn::make('publisher')
                //     ->placeholder('N/A')
                //     ->toggleable()
                //     ->sortable()
                //     ->searchable(),

                // TextColumn::make('copyright')
                //     ->placeholder('N/A')
                //     ->toggleable()
                //     ->sortable()
                //     ->searchable(),

                // TextColumn::make('instagram')
                //     ->placeholder('N/A')
                //     ->toggleable()
                //     ->sortable()
                //     ->searchable(),

                TextColumn::make('release_date')
                    ->toggleable()
                    ->date('M d, Y')
                    ->label('Song Release Date'),

                // TextColumn::make('languages')
                //     ->toggleable()
                //     ->badge()
                //     ->label('Song Languages'),

                // TextColumn::make('youtube_link')
                //     ->placeholder('N/A')
                //     ->label('YouTube Link'),

                TextColumn::make('isrc_code')
                    ->placeholder('N/A')
                    ->label('ISRC Code'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst($state)),

                // TextColumn::make('reject_reason')
                //     ->placeholder('N/A')
                //     ->label('Reject Reason'),

                // TextColumn::make('reward')
                //     ->sortable(),

                // TextColumn::make('is_added')
                //     ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No')
                //     ->label('Added in Wallet'),

                // TextColumn::make('created_at')
                //     ->date('M d, Y h:i A')
                //     ->label('Uploaded At'),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Uploaded From'),
                        DatePicker::make('created_until')
                            ->label('Uploaded To'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

                Filter::make('release_date')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Release Date From'),
                        DatePicker::make('created_until')
                            ->label('Release Date To'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('release_date', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('release_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-play')
                    ->color('info')
                    ->label('Play Video'),

                Action::make('view_report')
                    ->label('View Report')
                    ->visible(function ($record) {
                        if ($record->report_file) {
                            return file_exists(public_path($record->report_file));
                        }
                        return false;
                    })
                    ->icon('heroicon-o-document-chart-bar')
                    ->color('success')
                    ->url(function ($record) {
                        return asset($record->report_file);
                    }, true),

                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => in_array($record->status, ['rejected'])),
                    
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => in_array($record->status, ['rejected'])),

            ])
            ->bulkActions([]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('video_path')
                    ->alignCenter()
                    ->label('Video')
                    ->columnSpanFull()
                    ->state(function ($record) {
                        $html = '<video width="1000" height="1000" controls>
                    <source src="' . asset($record->video_path) . '" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>';
                        return new HtmlString($html);
                    })
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
            'index' => Pages\ListVideoSongs::route('/'),
            'create' => Pages\CreateVideoSong::route('/create'),
            // 'edit' => Pages\EditVideoSong::route('/{record}/edit'),
            
        ];
    }
}
