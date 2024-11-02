<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Song;
use Filament\Tables;
use App\Models\Label;
use App\Models\Artists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\SongResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SongResource\RelationManagers;

class SongResource extends Resource
{
    protected static ?string $model = Song::class;

    protected static ?string $modelLabel = 'Audio Song';

    protected static ?string $pluralModelLabel = 'Audio Songs';

    protected static ?string $navigationIcon = 'heroicon-o-musical-note';

/*
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->label('Song Name'),

                TagsInput::make('singers')
                    ->placeholder(NULL)
                    ->required()
                    ->label('Singer Name'),

                TagsInput::make('lyrics')
                    ->placeholder(NULL)
                    ->required()
                    ->label('Lyrics/Composition'),

                TagsInput::make('composer')
                    ->placeholder(NULL)
                    ->required()
                    ->label('Music/Composer'),

                TextInput::make('publisher'),

                TextInput::make('copyright'),

                TextInput::make('instagram'),

                DatePicker::make('release_date')
                    ->required()
                    ->label('Song Release Date'),

                TagsInput::make('languages')
                    ->placeholder(NULL)
                    ->required()
                    ->label('Song Languages'),

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

                Grid::make(5)
                    ->schema([
                        Toggle::make('stream_store')
                            ->onColor('success')
                            ->label('All Music Streaming Store'),

                        Toggle::make('fb_ig_music')
                            ->onColor('success')
                            ->label('Facebook and Instagram Music'),

                        Toggle::make('yt_content_id')
                            ->onColor('success')
                            ->label('YouTube Content ID'),

                        Toggle::make('explicit')
                            ->onColor('success'),

                        Toggle::make('caller_tune')
                            ->live()
                            ->onColor('success')
                            ->label('Caller Tune'),

                    ]),

                Grid::make(2)
                    ->visible(fn ($get) => $get('caller_tune'))
                    ->schema([
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

                Grid::make(3)
                    ->schema([
                        FileUpload::make('cover_photo')
                            ->label('Upload Cover Photo')
                            ->disk('public')
                            ->directory('uploads/cover_photos')
                            ->image()
                            ->imageEditor()
                            ->rules(['dimensions:width=3000,height=3000'])
                            ->validationMessages([
                                'dimensions' => 'Please upload 3000 x 3000 resolution image.',
                                'max' => 'The cover photo must not be greater than 20 MB.'
                            ])
                            ->maxSize(20 * 1024)
                            ->required(),

                        FileUpload::make('song_path')
                            ->label('Upload Song')
                            ->disk('public')
                            ->directory('uploads/songs')
                            ->acceptedFileTypes(['audio/mpeg', 'audio/x-mpeg', 'audio/x-wav', 'audio/wav'])
                            ->rules(['mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav'])
                            ->validationMessages([
                                'mimes' => 'Please upload only .mp3 or .wav file.',
                                'max' => 'The song must not be greater than 200 MB.'
                            ])
                            ->maxSize(2000 * 1024)
                            ->required(),

                        FileUpload::make('report_file')
                            ->label('Upload Report')
                            ->disk('public')
                            ->directory('uploads/reports')
                            ->acceptedFileTypes(['application/pdf']),

                    ]),

            ]);
    }
*/

public static function form(Form $form): Form
{
    return $form
        ->schema([

                Section::make('')
                ->schema([
                    
                TextInput::make('name')
                ->unique(ignoreRecord: true)
                ->required()
                ->label('Song Name'),

                Select::make('artists_id')
                ->label('Artists')
                ->required()
                ->native(false)
                ->multiple()
                ->options(function($record){
                    return $record && $record->customer_id ? Artists::where('customer_id', $record->customer_id)->pluck('name', 'id') : [];
                    // return Artists::where('customer_id', 1)->pluck('name', 'id');
                }),
                // ->createOptionForm([
                //     Section::make('Create Artist')
                //         ->schema([
                //             Forms\Components\FileUpload::make('profile')
                //                 ->label('Profile')
                //                 ->image()
                //                 ->required()
                //                 ->maxSize(20 * 1024)
                //                 ->disk('public')
                //                 ->directory('uploads/profile')
                //                 ->columnSpanFull(),

                //             Forms\Components\Hidden::make('customer_id')->default(1),

                //             Forms\Components\TextInput::make('name')->label('Artist Name')->required(),
                //             Forms\Components\TextInput::make('spotify_id')->label('Spotify ID'),
                //             Forms\Components\TextInput::make('apple_id')->label('Apple ID'),
                //             Forms\Components\TextInput::make('email')->email(),
                //             Forms\Components\TextInput::make('instagram')->required(),
                //             Forms\Components\TextInput::make('facebook')->required(),
                //             Forms\Components\Textarea::make('about')->columnSpanFull(),
                //         ])->columns(3),
                // ])
                // ->createOptionUsing(function ($data) {
                //     $artist = Artists::create($data);
                //     return $artist->id;
                // }),

                TextInput::make('publisher')->label('Lyricists Name'),

                TagsInput::make('composer')
                ->placeholder(NULL)
                ->required()
                ->label('Music/Composer'),

                TextInput::make('produser_name')->required(),

                Select::make('label_id')
                ->label('Label')
                ->required()
                ->native(false)
                ->options(function ($record) {
                    // Use customer_id from the current record to filter labels
                    return $record && $record->customer_id
                        ? Label::where('customer_id', $record->customer_id)
                                ->where('status', '1')
                                ->pluck('title', 'id')
                        : [];
                })

            ])->columns(3),

            Section::make('')
                ->schema([

                    TextInput::make('instagram')->label('Singer Instagram Handle')->required(),

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
                            'pop' => 'Pop',
                            'folk' => 'Folk',
                            'hip_hop' => 'Hip Hop',
                            'trance' => 'Trance',
                            'reggae' => 'Reggae',
                            'jazz' => 'Jazz',
                            'metal' => 'Metal',
                            'rnb' => 'R&B',
                            'dance' => 'Dance',
                            'house' => 'House',
                            'electronic' => 'Electronic',
                            'rock' => 'Rock',
                            'blues' => 'Blues',
                            'country' => 'Country',
                            'soul' => 'Soul',
                            'rnb' => 'R&B',
                            'salsa' => 'Salsa',
                            'funk' => 'Funk',
                            'disco' => 'Disco',
                            'alternative' => 'Alternative',
                            'indie' => 'Indie',
                            'trap' => 'Trap',
                            'world' => 'World',
                            'new_age' => 'New Age',
                            'soundtrack' => 'Soundtrack',
                            'afrobeat' => 'Afrobeat',
                            'dubstep' => 'Dubstep',
                            'future_bass' => 'Future Bass',
                            'indian' => 'Indian',
                            'world_music' => 'World Music',
                            'devotional' => 'Devotional',
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
                                'bollywood_dance' => 'Bollywood Dance',
                                'bollywood_romantic' => 'Bollywood Romantic',
                                'bollywood_hiphop' => 'Bollywood Hip-Hop',
                                'bollywood_qawwali' => 'Bollywood Qawwali',
                                'bollywood_sufi' => 'Bollywood Sufi',
                                'bollywood_ghazal' => 'Bollywood Ghazal',
                                'bollywood_jazz' => 'Bollywood Jazz',
                                'bollywood_blues' => 'Bollywood Blues',
                                'bollywood_punjabi' => 'Bollywood Punjabi',
                                'bollywood_bhajan' => 'Bollywood Bhajan',
                                'bollywood_lullaby' => 'Bollywood Lullaby',
                                'bollywood_item_number' => 'Bollywood Item Number',
                                'bollywood_bhangra' => 'Bollywood Bhangra',
                                'bollywood_devotional' => 'Bollywood Devotional',
                                'bollywood_melodic' => 'Bollywood Melodic',
                                'bollywood_indie' => 'Bollywood Indie',

                                // Sub-genres of Classical
                                'classical' => 'Classical',
                                'hindustani' => 'Hindustani',
                                'carnatic' => 'Carnatic',
                                'baroque' => 'Baroque',
                                'romantic' => 'Romantic',
                                'renaissance' => 'Renaissance',
                                'medieval' => 'Medieval',
                                'contemporary' => 'Contemporary',
                                'neoclassical' => 'Neoclassical',
                                'impressionism' => 'Impressionism',
                                'expressionism' => 'Expressionism',
                                'minimalism' => 'Minimalism',
                                'early_classical' => 'Early Classical',
                                '20th_century' => '20th Century Classical',
                                'modern' => 'Modern',
                                'galant' => 'Galant',

                                // Sub-genres of Pop
                                'pop_rock' => 'Pop Rock',
                                'synthpop' => 'Synthpop',
                                'dance_pop' => 'Dance Pop',
                                'teen_pop' => 'Teen Pop',
                                'k_pop' => 'K-Pop',
                                'electropop' => 'Electropop',
                                'latin_pop' => 'Latin Pop',
                                'chamber_pop' => 'Chamber Pop',
                                'indie_pop' => 'Indie Pop',
                                'power_pop' => 'Power Pop',
                                'hyperpop' => 'Hyperpop',
                                'j_pop' => 'J-Pop',
                                'baroque_pop' => 'Baroque Pop',
                                'art_pop' => 'Art Pop',
                                'dream_pop' => 'Dream Pop',
                                'pop_punk' => 'Pop Punk',
                                'twee_pop' => 'Twee Pop',
                                'folk_pop' => 'Folk Pop',
                                'sophisti_pop' => 'Sophisti-Pop',
                                'psychedelic_pop' => 'Psychedelic Pop',
                                'trap_pop' => 'Trap Pop',

                                // Sub-genres of Folk
                                'baul' => 'Baul',
                                'bhojpuri' => 'Bhojpuri',
                                'bhangra' => 'Bhangra',
                                'ghazal' => 'Ghazal',
                                'bhajan' => 'Bhajan',
                                'marathi' => 'Marathi',
                                'punjabi' => 'Punjabi',
                                'rajasthani' => 'Rajasthani',
                                'tamil' => 'Tamil Folk',
                                'telugu' => 'Telugu Folk',
                                'kannada' => 'Kannada Folk',
                                'garhwali' => 'Garhwali',
                                'kumaoni' => 'Kumaoni',
                                'bengali' => 'Bengali Folk',
                                'malayalam' => 'Malayalam Folk',
                                'oriya' => 'Oriya Folk',
                                'assamese' => 'Assamese Folk',
                                'lavani' => 'Lavani',
                                'narrative' => 'Narrative Folk',
                                'sufi' => 'Sufi',
                                'tribal' => 'Tribal Folk',
                                'haryanvi' => 'Haryanvi Folk',
                                'santali' => 'Santali Folk',
                                'sufi_qawwali' => 'Sufi Qawwali',
                                'northeastern' => 'Northeastern Folk',
                                'folk_ballad' => 'Folk Ballad',
                                'bluegrass' => 'Bluegrass',
                                'country' => 'Country Folk',
                                'celtic' => 'Celtic',
                                'american' => 'American Folk',
                                'nordic' => 'Nordic Folk',
                                'arabic' => 'Arabic Folk',
                                'latin' => 'Latin Folk',
                                'gypsy' => 'Gypsy',

                                // Sub-genres of Hip Hop
                                'old_school' => 'Old School',
                                'new_school' => 'New School',
                                'trap' => 'Trap',
                                'gangsta' => 'Gangsta',
                                'conscious' => 'Conscious',
                                'lofi' => 'Lo-fi',
                                'crunk' => 'Crunk',
                                'mumble' => 'Mumble',
                                'boom_bap' => 'Boom Bap',
                                'gfunk' => 'G-Funk',
                                'drill' => 'Drill',
                                'cloud' => 'Cloud Rap',
                                'phonk' => 'Phonk',
                                'trap_metal' => 'Trap Metal',
                                'jazz_rap' => 'Jazz Rap',
                                'emo_rap' => 'Emo Rap',
                                'alternative' => 'Alternative Hip Hop',
                                'underground' => 'Underground',
                                'southern' => 'Southern Hip Hop',
                                'west_coast' => 'West Coast Hip Hop',
                                'east_coast' => 'East Coast Hip Hop',
                                'chopper' => 'Chopper',
                                'bounce' => 'Bounce',
                                'grime' => 'Grime',
                                'boom_bap' => 'Boom Bap',
                                'trap' => 'Trap',
                                'drill' => 'Drill',
                                'lofi' => 'Lo-fi',
                                'conscious' => 'Conscious',
                                'gangsta' => 'Gangsta',
                                'trap_metal' => 'Trap Metal',
                                'cloud_rap' => 'Cloud Rap',
                                'trap_soul' => 'Trap Soul',
                                'jazz_rap' => 'Jazz Rap',
                                'underground' => 'Underground',
                                'west_coast' => 'West Coast',
                                'east_coast' => 'East Coast',
                                'alternative' => 'Alternative',
                                'southern' => 'Southern',
                                'grime' => 'Grime',
                                'nerdcore' => 'Nerdcore',
                                'hyphy' => 'Hyphy',
                                'crunk' => 'Crunk',
                                'freestyle' => 'Freestyle',
                                'new_school' => 'New School',
                                'old_school' => 'Old School',
                                'melodic_rap' => 'Melodic Rap',

                                // Sub-genres of Trance
                                'progressive' => 'Progressive',
                                'psychedelic' => 'Psychedelic',
                                'uplifting' => 'Uplifting',
                                'vocal' => 'Vocal',
                                'hard' => 'Hard',
                                'tech' => 'Tech',
                                'acid' => 'Acid',
                                'euphoric' => 'Euphoric',
                                'goa' => 'Goa',
                                'ambient' => 'Ambient',
                                'dream' => 'Dream',
                                'progressive_psytrance' => 'Progressive Psytrance',
                                'full_on' => 'Full-On',
                                'dark' => 'Dark',
                                'forest' => 'Forest',
                                'classic' => 'Classic',
                                'deep' => 'Deep',
                                'liquid' => 'Liquid',
                                'tribal' => 'Tribal',

                                // Sub-genres of Reggae
                                'roots' => 'Roots Reggae',
                                'dub' => 'Dub',
                                'dancehall' => 'Dancehall',
                                'ragga' => 'Ragga',
                                'lovers_rock' => 'Lovers Rock',
                                'reggaeton' => 'Reggaeton',
                                'rocksteady' => 'Rocksteady',
                                'early_reggae' => 'Early Reggae',
                                'conscious_reggae' => 'Conscious Reggae',
                                'rub_a_dub' => 'Rub-a-Dub',
                                'digital_reggae' => 'Digital Reggae',
                                'steppers' => 'Steppers',
                                'bashment' => 'Bashment',
                                'nyabinghi' => 'Nyabinghi',
                                'modern_reggae' => 'Modern Reggae',
                                'reggae_fusion' => 'Reggae Fusion',
                                'dubstep' => 'Dubstep',
                                'jungle' => 'Jungle',

                                // Sub-genres of Jazz
                                'traditional' => 'Traditional',
                                'swing' => 'Swing',
                                'bebop' => 'Bebop',
                                'hard_bop' => 'Hard Bop',
                                'cool_jazz' => 'Cool Jazz',
                                'modal_jazz' => 'Modal Jazz',
                                'free_jazz' => 'Free Jazz',
                                'fusion' => 'Fusion',
                                'smooth_jazz' => 'Smooth Jazz',
                                'latin_jazz' => 'Latin Jazz',
                                'afro_cuban' => 'Afro-Cuban Jazz',
                                'gypsy_jazz' => 'Gypsy Jazz',
                                'avant_garde' => 'Avant-Garde Jazz',
                                'post_bop' => 'Post-Bop',
                                'bossa_nova' => 'Bossa Nova',
                                'nu_jazz' => 'Nu Jazz',
                                'acid_jazz' => 'Acid Jazz',
                                'jazz_rap' => 'Jazz Rap',
                                'contemporary_jazz' => 'Contemporary Jazz',
                                'jazz_funk' => 'Jazz Funk',

                                // Sub-genres of Metal
                                'heavy_metal' => 'Heavy Metal',
                                'thrash_metal' => 'Thrash Metal',
                                'death_metal' => 'Death Metal',
                                'black_metal' => 'Black Metal',
                                'doom_metal' => 'Doom Metal',
                                'power_metal' => 'Power Metal',
                                'folk_metal' => 'Folk Metal',
                                'gothic_metal' => 'Gothic Metal',
                                'progressive_metal' => 'Progressive Metal',
                                'nu_metal' => 'Nu Metal',
                                'groove_metal' => 'Groove Metal',
                                'speed_metal' => 'Speed Metal',
                                'symphonic_metal' => 'Symphonic Metal',
                                'industrial_metal' => 'Industrial Metal',
                                'sludge_metal' => 'Sludge Metal',
                                'metalcore' => 'Metalcore',
                                'melodic_death_metal' => 'Melodic Death Metal',
                                'viking_metal' => 'Viking Metal',
                                'blackened_death_metal' => 'Blackened Death Metal',
                                'post_metal' => 'Post-Metal',
                                'technical_death_metal' => 'Technical Death Metal',
                                'djent' => 'Djent',
                                'stoner_metal' => 'Stoner Metal',

                                // Sub-genres of R&B
                                'r&b_soul' => 'R&B Soul',
                                'neo_soul' => 'Neo Soul',
                                'contemporary_r&b' => 'Contemporary R&B',
                                'funk' => 'Funk',
                                'hip_hop_soul' => 'Hip Hop Soul',
                                'smooth_r&b' => 'Smooth R&B',
                                'new_jack_swing' => 'New Jack Swing',
                                'southern_soul' => 'Southern Soul',
                                'quiet_storm' => 'Quiet Storm',
                                'progressive_r&b' => 'Progressive R&B',
                                'blue_eyed_soul' => 'Blue-Eyed Soul',
                                'modern_soul' => 'Modern Soul',
                                'alternative_r&b' => 'Alternative R&B',
                                'jazz_r&b' => 'Jazz R&B',
                                'vintage_r&b' => 'Vintage R&B',

                                // Sub-genres of Dance
                                'dance-pop' => 'Dance-pop',
                                'deep-house' => 'Deep House',
                                'techno' => 'Techno',
                                'trance' => 'Trance',
                                'dubstep' => 'Dubstep',
                                'drum-and-bass' => 'Drum and Bass',
                                'house' => 'House',
                                'disco' => 'Disco',
                                'breakbeat' => 'Breakbeat',
                                'hardstyle' => 'Hardstyle',
                                'progressive-house' => 'Progressive House',
                                'synth-pop' => 'Synth-pop',
                                'future-bass' => 'Future Bass',
                                'ethnic-dance' => 'Ethnic Dance',
                                'electro-swing' => 'Electro Swing',
                                'garage' => 'Garage',
                                'tech-house' => 'Tech House',
                                'samba' => 'Samba',
                                'hip-hop' => 'Hip Hop',
                                'reggaeton' => 'Reggaeton',
                                'street-dance' => 'Street Dance',
                                'contemporary' => 'Contemporary',

                                // Sub-genres of House
                                'soulful' => 'Soulful House',
                                'deep' => 'Deep House',
                                'progressive' => 'Progressive House',
                                'tech' => 'Tech House',
                                'disco' => 'Disco House',
                                'futuristic' => 'Futuristic House',
                                'vocal' => 'Vocal House',
                                'minimal' => 'Minimal House',
                                'garage' => 'Garage House',
                                'afro' => 'Afro House',
                                'tribal' => 'Tribal House',
                                'funky' => 'Funky House',
                                'electro' => 'Electro House',
                                'Chicago' => 'Chicago House',
                                'Detroit' => 'Detroit House',
                                'new' => 'New House',
                                'ambient' => 'Ambient House',
                                'lo-fi' => 'Lo-fi House',
                                'hard' => 'Hard House',

                                // Sub-genres of Electronic
                                'electro' => 'Electro',
                                'house' => 'House',
                                'techno' => 'Techno',
                                'trance' => 'Trance',
                                'dubstep' => 'Dubstep',
                                'drum_and_bass' => 'Drum and Bass',
                                'ambient' => 'Ambient',
                                'industrial' => 'Industrial',
                                'glitch' => 'Glitch',
                                'future_bass' => 'Future Bass',
                                'deep_house' => 'Deep House',
                                'progressive_house' => 'Progressive House',
                                'trap' => 'Trap',
                                'retrowave' => 'Retrowave',
                                'liquid_dnb' => 'Liquid Drum and Bass',
                                'hardstyle' => 'Hardstyle',
                                'synthwave' => 'Synthwave',
                                'breakbeat' => 'Breakbeat',
                                'psytrance' => 'Psytrance',
                                'minimal' => 'Minimal',
                                'big_room' => 'Big Room',

                                // Sub-genres of Rock
                                'shard' => 'Shred',
                                'alternative' => 'Alternative Rock',
                                'indie' => 'Indie Rock',
                                'grunge' => 'Grunge',
                                'punk' => 'Punk Rock',
                                'progressive' => 'Progressive Rock',
                                'metal' => 'Heavy Metal',
                                'soft' => 'Soft Rock',
                                'blues' => 'Blues Rock',
                                'southern' => 'Southern Rock',
                                'psychedelic' => 'Psychedelic Rock',
                                'garage' => 'Garage Rock',
                                'new_wave' => 'New Wave',
                                'pop_punk' => 'Pop Punk',
                                'emo' => 'Emo',
                                'post_rock' => 'Post-Rock',
                                'metalcore' => 'Metalcore',
                                'pop_rock' => 'Pop Rock',
                                'math_rock' => 'Math Rock',
                                'industrial' => 'Industrial Rock',
                                'hardcore' => 'Hardcore Punk',
                                'acid' => 'Acid Rock',
                                'grunge' => 'Grunge',
                                'stoner' => 'Stoner Rock',
                                'prog_metal' => 'Progressive Metal',
                                'space' => 'Space Rock',
                                'folk_rock' => 'Folk Rock',
                                'surf' => 'Surf Rock',
                                'rockabilly' => 'Rockabilly',
                                'cowpunk' => 'Cowpunk',
                                'emo' => 'Emo',

                                // Sub-genres of Blues
                                'delta_blues' => 'Delta Blues',
                                'chicago_blues' => 'Chicago Blues',
                                'electric_blues' => 'Electric Blues',
                                'country_blues' => 'Country Blues',
                                'jump_blues' => 'Jump Blues',
                                'southern_blues' => 'Southern Blues',
                                'rhythm_and_blues' => 'Rhythm and Blues (R&B)',
                                'blues_rock' => 'Blues Rock',
                                'swamp_blues' => 'Swamp Blues',
                                'boogie_woogie' => 'Boogie Woogie',

                                // Sub-genres of Country
                                'southern_rock' => 'Southern Rock',
                                'bluegrass' => 'Bluegrass',
                                'country_rock' => 'Country Rock',
                                'traditional_country' => 'Traditional Country',
                                'contemporary_country' => 'Contemporary Country',
                                'outlaw_country' => 'Outlaw Country',
                                'alt_country' => 'Alternative Country',
                                'bro_country' => 'Bro Country',
                                'swing' => 'Country Swing',
                                'cowpunk' => 'Cowpunk',
                                'country_pop' => 'Country Pop',
                                'americana' => 'Americana',
                                'texas_country' => 'Texas Country',
                                'country_folk' => 'Country Folk',
                                'country_blues' => 'Country Blues',
                                'honky_tonk' => 'Honky Tonk',

                                // Sub-genres of Soul
                                'southern_soul' => 'Southern Soul',
                                'neo_soul' => 'Neo Soul',
                                'deep_soul' => 'Deep Soul',
                                'psychadelic_soul' => 'Psychedelic Soul',
                                'soul_blues' => 'Soul Blues',
                                'funk' => 'Funk',
                                'contemporary_r&b' => 'Contemporary R&B',
                                'motown' => 'Motown',
                                'gospel' => 'Gospel',
                                'vintage_soul' => 'Vintage Soul',

                                // Sub-genres of Salsa
                                'salsa_dura' => 'Salsa Dura',
                                'salsa_romantica' => 'Salsa Romántica',
                                'new_york_style' => 'New York Style',
                                'puerto_rican_style' => 'Puerto Rican Style',
                                'latin_jazz' => 'Latin Jazz',
                                'colombian_salsa' => 'Colombian Salsa',
                                'charanga' => 'Charanga',
                                'crossbody' => 'Crossbody Salsa',
                                'cuban_salsa' => 'Cuban Salsa',
                                'urban_salsa' => 'Urban Salsa',

                                // Sub-genres of Funk
                                'funk' => 'Funk',
                                'boogie' => 'Boogie',
                                'p-funk' => 'P-Funk',
                                'soul-funk' => 'Soul Funk',
                                'jazz-funk' => 'Jazz Funk',
                                'psychadelic-funk' => 'Psychedelic Funk',
                                'disco-funk' => 'Disco Funk',
                                'funk-rock' => 'Funk Rock',
                                'funk-metal' => 'Funk Metal',
                                'new-funk' => 'New Funk',
                                'funk-house' => 'Funk House',
                                'blaxploitation' => 'Blaxploitation',
                                'retro-funk' => 'Retro Funk',
                                'lo-fi-funk' => 'Lo-Fi Funk',

                                // Sub-genres of Disco
                                    'classic' => 'Classic Disco',
                                    'french' => 'French Disco',
                                    'italo' => 'Italo Disco',
                                    'hi_nrg' => 'Hi-NRG',
                                    'disco_funk' => 'Disco Funk',
                                    'soul' => 'Soul Disco',
                                    'disco_rock' => 'Disco Rock',
                                    'disco_house' => 'Disco House',
                                    'disco_tech' => 'Disco Tech',
                                    'nu_disco' => 'Nu Disco',
                                    'hindustani' => 'Hindustani',
                                    'carnatic' => 'Carnatic',
                                    'baroque' => 'Baroque',
                                    'romantic' => 'Romantic',

                                // Sub-genres of Alternative
                                'alternative_rock' => 'Alternative Rock',
                                'indie_rock' => 'Indie Rock',
                                'post_punk' => 'Post Punk',
                                'grunge' => 'Grunge',
                                'dream_pop' => 'Dream Pop',
                                'shoegaze' => 'Shoegaze',
                                'folk_rock' => 'Folk Rock',
                                'progressive_rock' => 'Progressive Rock',
                                'noise_rock' => 'Noise Rock',
                                'ambient' => 'Ambient',
                                'new_wave' => 'New Wave',
                                'synthpop' => 'Synthpop',
                                'industrial' => 'Industrial',
                                'ethereal_wave' => 'Ethereal Wave',
                                'math_rock' => 'Math Rock',
                                'emo' => 'Emo',
                                'garage_rock' => 'Garage Rock',
                                'surf_rock' => 'Surf Rock',

                                // Sub-genres of Indie
                                'hindustani' => 'Hindustani',
                                'carnatic' => 'Carnatic',
                                'baroque' => 'Baroque',
                                'romantic' => 'Romantic',
                                'folk' => 'Folk',
                                'lo-fi' => 'Lo-fi',
                                'synth-pop' => 'Synth-pop',
                                'alternative' => 'Alternative',
                                'indie-rock' => 'Indie Rock',
                                'indie-pop' => 'Indie Pop',
                                'post-rock' => 'Post Rock',
                                'chamber-pop' => 'Chamber Pop',
                                'art-pop' => 'Art Pop',
                                'dream-pop' => 'Dream Pop',
                                'math-rock' => 'Math Rock',
                                'indie-folk' => 'Indie Folk',
                                'electro-folk' => 'Electro Folk',

                                // Sub-genres of Trap
                                'hindustani' => 'Hindustani',
                                'carnatic' => 'Carnatic',
                                'baroque' => 'Baroque',
                                'romantic' => 'Romantic',
                                'lofi' => 'Lofi',
                                'hardtrap' => 'Hard Trap',
                                'cloudtrap' => 'Cloud Trap',
                                'trapmetal' => 'Trap Metal',
                                'dirtysouth' => 'Dirty South',
                                'chicago' => 'Chicago',
                                'phonk' => 'Phonk',
                                'future' => 'Future Trap',

                                // Sub-genres of World
                                'hindustani' => 'Hindustani',
                                'carnatic' => 'Carnatic',
                                'baroque' => 'Baroque',
                                'romantic' => 'Romantic',
                                'african' => 'African',
                                'eggae' => 'Reggae',
                                'flamenco' => 'Flamenco',
                                'klezmer' => 'Klezmer',
                                'celtic' => 'Celtic',
                                'latin' => 'Latin',
                                'samba' => 'Samba',
                                'bossa_nova' => 'Bossa Nova',
                                'gamelan' => 'Gamelan',
                                'bluegrass' => 'Bluegrass',
                                'fado' => 'Fado',
                                'tuvan' => 'Tuvan',
                                'native_american' => 'Native American',
                                'polka' => 'Polka',
                                'worldbeat' => 'Worldbeat',

                                // Sub-genres of New Age
                                'hindustani' => 'Hindustani',
                                'carnatic' => 'Carnatic',
                                'baroque' => 'Baroque',
                                'romantic' => 'Romantic',
                                'ambient' => 'Ambient',
                                'tribal' => 'Tribal',
                                'neoclassical' => 'Neoclassical',
                                'world' => 'World',
                                'nature' => 'Nature Sounds',
                                'spiritual' => 'Spiritual',
                                'meditative' => 'Meditative',
                                'healing' => 'Healing',
                                'instrumental' => 'Instrumental',

                                // Sub-genres of Soundtrack New Age
                                'hindustani' => 'Hindustani',
                                'carnatic' => 'Carnatic',
                                'baroque' => 'Baroque',
                                'romantic' => 'Romantic',
                                'ambient' => 'Ambient',
                                'neoclassical' => 'Neoclassical',
                                'chillout' => 'Chillout',
                                'cinematic' => 'Cinematic',
                                'electronic' => 'Electronic',
                                'fusion' => 'Fusion',
                                'instrumental' => 'Instrumental',
                                'new_age' => 'New Age',
                                'ethereal' => 'Ethereal',

                                // Sub-genres of Afrobeat
                                'afro-fusion' => 'Afro-Fusion',
                                'afro-soul' => 'Afro-Soul',
                                'afro-house' => 'Afro-House',
                                'afro-jazz' => 'Afro-Jazz',
                                'afro-pop' => 'Afro-Pop',
                                'afrobeat' => 'Afrobeat',
                                'highlife' => 'Highlife',
                                'juju' => 'Juju',
                                'fela-kuti' => 'Fela Kuti Style',
                                'contemporary-afrobeat' => 'Contemporary Afrobeat',
                                'soukous' => 'Soukous',
                                'kuduro' => 'Kuduro',
                                'azonto' => 'Azonto',

                                // Sub-genres of Dubstep
                                'dub' => 'Dub',
                                'brostep' => 'Brostep',
                                'deep dubstep' => 'Deep Dubstep',
                                'future garage' => 'Future Garage',
                                'trap' => 'Trap',
                                'wonky' => 'Wonky',
                                'step' => 'Step',
                                'halftime' => 'Halftime',
                                'glitch hop' => 'Glitch Hop',
                                'heavy dubstep' => 'Heavy Dubstep',
                                'UK garage' => 'UK Garage',
                                'post-dubstep' => 'Post-Dubstep',
                                'moombahton' => 'Moombahton',
                                'drumstep' => 'Drumstep',
                                'skate punk' => 'Skate Punk',
                                'jungle' => 'Jungle',

                                // Sub-genres of Future Bass
                                'hindustani' => 'Hindustani',
                                'carnatic' => 'Carnatic',
                                'baroque' => 'Baroque',
                                'romantic' => 'Romantic',
                                'chillstep' => 'Chillstep',
                                'vaporwave' => 'Vaporwave',
                                'trap' => 'Trap',
                                'juke' => 'Juke',
                                'futurepop' => 'Future Pop',
                                'lofi' => 'Lofi Future Bass',

                                // Sub-genres of World Music
                                'samba' => 'Samba',
                                'bhangra' => 'Bhangra',
                                'reggae' => 'Reggae',
                                'afrobeat' => 'Afrobeat',
                                'flamenco' => 'Flamenco',
                                'kuhmo' => 'Kuhmo',
                                'celtic' => 'Celtic',
                                'traditional' => 'Traditional',
                                'folklore' => 'Folklore',
                                'bluegrass' => 'Bluegrass',
                                'jazz' => 'Jazz',
                                'blues' => 'Blues',
                                'latin' => 'Latin',
                                'sufi' => 'Sufi',
                                'ambient' => 'Ambient',
                                'new-age' => 'New Age',
                                'fusion' => 'Fusion',
                                'worldbeat' => 'Worldbeat',
                                'ethnic' => 'Ethnic',
                                'tribal' => 'Tribal',
                                'polka' => 'Polka',
                                'gypsy' => 'Gypsy',
                                'carnival' => 'Carnival',
                                'socca' => 'Socca',
                                'charanga' => 'Charanga',
                                'caribbean' => 'Caribbean',
                                'gypsy-jazz' => 'Gypsy Jazz',
                                'bossa-nova' => 'Bossa Nova',
                                'cumbia' => 'Cumbia',
                                'kalinka' => 'Kalinka',
                                'harlem' => 'Harlem',
                                'klezmer' => 'Klezmer',
                                'qabalah' => 'Qabalah',
                                'istanbul' => 'Istanbul',
                                'cuban' => 'Cuban',
                                'maracatu' => 'Maracatu',
                                'jig' => 'Jig',
                                'ud' => 'Ud',
                                'katak' => 'Katak',
                                'balalaika' => 'Balalaika',
                                'tuvan' => 'Tuvan',
                                'paraguayan' => 'Paraguayan',
                                'gnawa' => 'Gnawa',
                                'koto' => 'Koto',
                                'mandolin' => 'Mandolin',

                                // Sub-genres of Indian
                                'hindustani' => 'Hindustani Classical',
                                'carnatic' => 'Carnatic Classical',
                                'folk' => 'Folk Music',
                                'devotional' => 'Devotional Music',
                                'fusion' => 'Fusion',
                                'sufi' => 'Sufi Music',
                                'bollywood' => 'Bollywood Music',
                                'qawwali' => 'Qawwali',
                                'ghazal' => 'Ghazal',
                                'bhangra' => 'Bhangra',
                                'raaga' => 'Raaga',
                                'dhruvapad' => 'Dhruvapad',
                                'light' => 'Light Music',
                                'instrumental' => 'Instrumental',
                                'baroque' => 'Baroque',
                                'romantic' => 'Romantic',

                                // Sub-genres of Indian Devotional
                                'hindustani' => 'Hindustani Classical',
                                'carnatic' => 'Carnatic Classical',
                                'bhajan' => 'Bhajan',
                                'kirtan' => 'Kirtan',
                                'arti' => 'Arti',
                                'chalisa' => 'Chalisa',
                                'sufi' => 'Sufi',
                                'shloka' => 'Shloka',
                                'mantra' => 'Mantra',
                                'baroque' => 'Baroque',
                                'folk' => 'Folk Devotional',
                                'qawwali' => 'Qawwali',
                                'gospel' => 'Gospel'
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

                    Grid::make(5)
                    ->schema([
                        Toggle::make('stream_store')
                            ->onColor('success')
                            ->label('All Music Streaming Store'),

                        Toggle::make('fb_ig_music')
                            ->onColor('success')
                            ->label('Facebook and Instagram Music'),

                        Toggle::make('yt_content_id')
                            ->onColor('success')
                            ->label('YouTube Content ID'),

                        Toggle::make('explicit')
                            ->onColor('success'),

                        Toggle::make('caller_tune')
                            ->live()
                            ->onColor('success')
                            ->label('Caller Tune'),

                    ]),

                Grid::make(2)
                    ->visible(fn ($get) => $get('caller_tune'))
                    ->schema([
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

                Grid::make(2)
                    ->schema([
                        FileUpload::make('cover_photo')
                            ->label('Upload Cover Photo')
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
                            ->required(),

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

                    ]),

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

                ])

        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_photo')
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->size(150)
                    ->toggleable()
                    ->label('Artwork')
                    ->url(function ($record) {
                        return asset($record->cover_photo);
                    })
                    ->openUrlInNewTab(),

                TextColumn::make('song_path')
                    ->toggleable()
                    ->formatStateUsing(function ($state) {
                        $audio_path = asset($state);
                        $html = '<audio controls src="' . $audio_path . '"></audio>';
                        return new HtmlString($html);
                    })
                    ->placeholder('N/A')
                    ->label('Song'),

                    TextColumn::make('customer.email')
                    ->placeholder('N/A')
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->label('Customer Email'),

                TextColumn::make('name')
                ->toggleable()
                ->sortable()
                ->searchable()
                ->label('Song Name'),


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

                TextColumn::make('publisher')->label('Lyricists Name')->toggleable()->badge(),

                TextColumn::make('composer')
                    ->toggleable()
                    ->badge()
                    ->label('Music/Composer'),

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

                TextColumn::make('instagram')
                    ->placeholder('N/A')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),


                TextColumn::make('label.title')->placeholder('N/A')
                ->toggleable()
                ->label('Song Label'),

                TextColumn::make('release_date')
                    ->toggleable()
                    ->date('M d, Y')
                    ->label('Release Date'),

                TextColumn::make('languages')
                    ->toggleable()
                    ->badge()
                    ->label('Song Languages'),

                IconColumn::make('stream_store')
                    ->toggleable()
                    ->boolean()
                    ->label('All Music Streaming Store'),

                IconColumn::make('fb_ig_music')
                    ->toggleable()
                    ->boolean()
                    ->label('Facebook and Instagram Music'),

                IconColumn::make('yt_content_id')
                    ->toggleable()
                    ->boolean()
                    ->label('YouTube Content ID'),

                IconColumn::make('explicit')
                    ->toggleable()
                    ->boolean(),

                IconColumn::make('caller_tune')
                    ->toggleable()
                    ->boolean()
                    ->label('Caller Tune'),

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

                TextColumn::make('reject_reason')
                    ->placeholder('N/A')
                    ->label('Reject Reason'),

                // TextInputColumn::make('reward')
                //     ->disabled(fn ($record) => $record->is_added)
                //     ->sortable()
                //     ->rules(['numeric', 'gte:0']),

                // TextColumn::make('is_added')
                //     ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No')
                //     ->label('Added in Wallet'),

                TextColumn::make('created_at')
                    ->date('M d, Y h:i A')
                    ->label('Uploaded At'),

                TextColumn::make('updated_at')
                    ->date('M d, Y h:i A')
                    ->label('Updated At'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),

                SelectFilter::make('customer_id')
                    ->relationship('customer', 'email')
                    ->preload()
                    ->searchable()
                    ->label('Customer Email'),

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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('view_report')
                    ->label('View Report')
                    ->visible(function ($record) {
                        if ($record->report_file) {
                            return file_exists(public_path($record->report_file));
                        }
                        return false;
                        // return $record->report_file ? true : false;
                    })
                    ->icon('heroicon-o-document-chart-bar')
                    ->color('success')
                    ->url(function ($record) {
                        return asset($record->report_file);
                    }, true)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\ExportAction::make()->exporter(\App\Filament\Exports\AdminSongResourceExporter::class)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                ]),
                ExportBulkAction::make()->exporter(\App\Filament\Exports\AdminSongResourceExporter::class)
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
            'index' => Pages\ListSongs::route('/'),
            // 'create' => Pages\CreateSong::route('/create'),
            'edit' => Pages\EditSong::route('/{record}/edit'),
        ];
    }
}
