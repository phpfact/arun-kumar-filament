<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Analytics;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Analytics Details')
                ->schema([

                    Forms\Components\Select::make('customer_id')->required()->preload()
                    ->relationship('customer', 'email')
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return "{$record->first_name} {$record->last_name} ({$record->email})";
                    }),

                    DatePicker::make('analytic_date')->native(false)->default(now()->format('Y-m-d')),

                    FileUpload::make('file_name')->columnSpanFull()
                    ->label('Analytics Attachment')
                    ->disk('public')
                    ->directory('uploads/analytic')
                    ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->rules(['mimes:csv,xls,xlsx'])
                    ->validationMessages([
                        'mimes' => 'Please upload only .csv, .xls, or .xlsx file.',
                        'max' => 'The file must not be greater than 200 MB.'
                    ])
                    ->required()

                ])->columns(2), 

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.first_name')->label('Customer Name'),
                Tables\Columns\TextColumn::make('customer.email')->label('Customer Email'),

                Tables\Columns\TextColumn::make('analytic_date')->dateTime('M Y')->label('Analytic Date'),

                TextColumn::make('file_name')
                ->formatStateUsing(function ($state) {
                    $excel_path = asset($state);
                    $html = '<a href="' . $excel_path . '" download class="download-btn">Download Excel</a>';
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
