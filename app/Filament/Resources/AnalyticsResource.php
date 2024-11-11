<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Label;
use Filament\Forms\Form;
use App\Models\Analytics;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AnalyticsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AnalyticsResource\RelationManagers;

class AnalyticsResource extends Resource
{
    protected static ?string $model = Analytics::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Analytics Details')
                ->schema([

                    // Forms\Components\Select::make('customer_id')->required()->preload()
                    // ->relationship('customer', 'email')
                    // ->getOptionLabelFromRecordUsing(function ($record) {
                    //     return "{$record->first_name} {$record->last_name} ({$record->email})";
                    // }),

                    Select::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'email')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->reactive() // Make this field reactive
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return "{$record->first_name} {$record->last_name} ({$record->email})";
                    }),

                    DatePicker::make('analytic_date')->label('Reports Update Date')->native(false)->default(now()->format('Y-m-d')),

                    Select::make('reports_month_name')->searchable()->options([
                        'january' => 'January',
                        'february' => 'February',
                        'march' => 'March',
                        'april' => 'April',
                        'may' => 'May',
                        'june' => 'June',
                        'july' => 'July',
                        'august' => 'August',
                        'september' => 'September',
                        'october' => 'October',
                        'november' => 'November',
                        'december' => 'December',
                    ])->label('Reports Month Name'),

                    Select::make('reports_year_name')
                    ->label('Reports Year')
                    ->searchable()
                    ->options(
                        collect(range(2020, 2099))->mapWithKeys(function ($year) {
                            return [$year => $year];
                        })
                    )
                    ->default(date('Y'))
                    ->required(),

                    Forms\Components\TextInput::make('reporting_stores')->required()->datalist([
                        'Spotify',
                        'Apple Music',
                        'Amazon Music',
                        'YouTube Music',
                        'Deezer',
                        'Tidal',
                        'Twitch',
                        'SoundCloud',
                        'Pandora',
                        'iHeartRadio',
                        'Anghami',
                        'Qobuz',
                        'Napster',
                        'Beatport',
                        'Facebook Music & Instagram Music',
                        'Gaana',
                        'JioSaavn',
                        'Hungama',
                        'Wynk Music',
                        'TikTok',
                        'Reliance Jio CRBT',
                        'Bharti Airtel CRBT',
                        'Vodafone Idea (Vi) CRBT',
                        'BSNL CRBT',
                        'MTNL CRBT',
                        'Telenor India CRBT',
                    ]),

                    // Forms\Components\TextInput::make('Label Name')->required(),

                    // Select::make('label_id')
                    // ->label('Label')
                    // ->required()
                    // ->native(false)
                    // ->options(function ($record) {
                    //     return Label::where('customer_id', $record->customer_id)->where('status', '1')->pluck('title', 'id');
                    // }),

                    Select::make('label_id')
                    ->label('Label')
                    ->required()
                    ->native(false)
                    ->options(function (callable $get) {
                        $customerId = $get('customer_id');
                        if (!$customerId) {
                            return [];
                        }
                        return Label::where('customer_id', $customerId)->where('status', '1')->pluck('title', 'id');
                    }),

                    FileUpload::make('file_name')
                    ->columnSpanFull()
                    ->label('Royalty Reports')
                    ->disk('public')
                    ->directory('uploads/analytic')
                    ->acceptedFileTypes([
                        'text/csv', 
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/pdf'
                    ])
                    ->rules(['mimes:csv,xls,xlsx,pdf', 'max:204800'])
                    ->validationMessages([
                        'mimes' => 'Please upload only .csv, .xls, .xlsx, or .pdf files.',
                        'max' => 'The file must not be greater than 200 MB.'
                    ])
                    ->required(),

                ])->columns(2), 

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.first_name')->label('Customer Name'),
                Tables\Columns\TextColumn::make('customer.email')->label('Customer Email'),

                Tables\Columns\TextColumn::make('analytic_date')->dateTime('d F Y')->label('Reports Update Date'),
                Tables\Columns\TextColumn::make('reports_month_name')->getStateUsing(fn ($record) => ucwords($record->reports_month_name) . ' ' . $record->reports_year_name)->label('Reports Month/Year'),
                Tables\Columns\TextColumn::make('reporting_stores')->label('Reporting Stores'),
                Tables\Columns\TextColumn::make('label.title')->label('Label'),
                TextColumn::make('file_name')
                ->formatStateUsing(function ($state) {
                    $excel_path = asset($state);
                    $html = '<a href="' . $excel_path . '" download class="download-btn">Download Report</a>';
                    $html .= '<style>.download-btn{display:inline-flex;align-items:center;justify-content:center;padding:10px 24px;font-size:14px;font-weight:600;color:#854d0e;background-color:#fef9c3;border:2px solid #facc15;border-radius:8px;text-decoration:none;transition:.2s ease-in-out;box-shadow:0 2px 4px rgba(250,204,21,.2)}.download-btn:hover{background-color:#fde047;border-color:#eab308;color:#713f12;transform:translateY(-1px);box-shadow:0 4px 6px rgba(234,179,8,.25)}.download-btn:active{background-color:#facc15;transform:translateY(0);box-shadow:0 1px 2px rgba(234,179,8,.2)}.download-btn:focus{outline:0;box-shadow:0 0 0 3px rgba(250,204,21,.4)}</style>';
                    return new HtmlString($html);
                })
                ->placeholder('N/A')
                ->label('')

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
            'index' => Pages\ListAnalytics::route('/'),
            'create' => Pages\CreateAnalytics::route('/create'),
            'edit' => Pages\EditAnalytics::route('/{record}/edit'),
        ];
    }
}
