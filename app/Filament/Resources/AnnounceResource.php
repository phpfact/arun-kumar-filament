<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Announce;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AnnounceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AnnounceResource\RelationManagers;

class AnnounceResource extends Resource
{
    protected static ?string $model = Announce::class;

    protected static ?string $modelLabel = 'Announcement';

    protected static ?string $pluralModelLabel = 'Announcements';

    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('')
                ->schema([

                    Forms\Components\TextInput::make('title')->placeholder('Festival Greetings to Everyone! 🎉')->required(),

                    Forms\Components\Select::make('icon')
                    ->label('Announcement Icon')
                    ->required()
                    ->options([
                        'heroicon-o-newspaper' => 'News',
                        'heroicon-o-exclamation-triangle' => 'Warning Triangle',
                        'heroicon-o-flag' => 'Flagged',
                        'heroicon-o-check-circle' => 'Check Circle',
                        'heroicon-o-bell-alert' => 'Notification Bell',
                        'heroicon-o-hand-thumb-up' => 'Thumbs Up',
                    ])->default('heroicon-o-bell-alert'),

                    Forms\Components\Textarea::make('body')->required()->placeholder('Wishing you all lots of joy and happiness on this festival! 🌟')->columnSpanFull()->rows(7),

                    Forms\Components\Select::make('announceTo')
                    ->label('Select Customer')
                    ->columnSpanFull()
                    ->searchable()
                    ->required()
                    ->preload()
                    ->options(function () {

                        $customers = Customer::all()->pluck('email', 'id')->toArray() ?? [];
                        $options = ['all' => 'All Customers'];
                        return $options + $customers;
                    
                    })
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return "{$record->first_name} {$record->last_name} ({$record->email})";
                    })->default('All Customers'),

                    Forms\Components\Select::make('status')
                    ->label('Status')
                    ->required()
                    ->columnSpanFull()
                    ->default('1')
                    ->options([
                        '1' => 'Keep Activated',
                        '0' => 'Remove Announcement',
                    ])
                    ->hidden(fn ($record) => ! $record)               

                ])->columns(2)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(NULL)
            ->columns([
                
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('announceTo')->searchable()->sortable()->formatStateUsing(function ($state) {
                    if ($state == 'all') {
                        return 'All Customers';
                    } else {
                        $customer = Customer::find($state);
                        return $customer->first_name . ' ' . $customer->last_name . ' (' . $customer->email . ')';
                    }
                }),

                Tables\Columns\TextColumn::make('created_at')->dateTime('l jS \of F Y h:i:s A')->sortable()->searchable()->label('Date Created'),

            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn ($record) => in_array($record->status, ['1'])),
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
            'index' => Pages\ListAnnounces::route('/'),
            'create' => Pages\CreateAnnounce::route('/create'),
            'edit' => Pages\EditAnnounce::route('/{record}/edit'),
        ];
    }
}
