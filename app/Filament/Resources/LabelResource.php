<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Label;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LabelResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LabelResource\RelationManagers;

class LabelResource extends Resource
{
    protected static ?string $model = Label::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Personal Information')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Label Name')
                        ->required(),

                    Forms\Components\TextInput::make('full_name')
                        ->label('Full Name'),

                    Forms\Components\TextInput::make('mobile_number')
                        ->label('Mobile Number')
                        ->numeric()
                        ->maxlength(10)
                        ->minlength(10),

                    Forms\Components\TextInput::make('email_id')
                        ->label('Email ID')
                        ->email(),

                    Forms\Components\TextInput::make('address_1')
                        ->label('Address Line 1'),

                    Forms\Components\TextInput::make('address_2')
                        ->label('Address Line 2'),

                    Forms\Components\TextInput::make('city')
                        ->label('City'),

                    Forms\Components\TextInput::make('state')
                        ->label('State'),

                    Forms\Components\TextInput::make('pincode')
                        ->label('Pincode')
                        ->numeric()
                        ->maxlength(6),

                ])->columns(3),

                Section::make('Aadhar Card Details')
                    ->schema([
                        FileUpload::make('aadhar_card_front')
                            ->label('Aadhar Card Front Photo')
                            ->disk('public')
                            ->directory('uploads/documents')
                            ->image()
                            ->maxSize(20 * 1024), // 20 MB

                        FileUpload::make('aadhar_card_back')
                            ->label('Aadhar Card Back Photo')
                            ->disk('public')
                            ->directory('uploads/documents')
                            ->image()
                            ->maxSize(20 * 1024), // 20 MB
                    ])->columns(2),

                Section::make('Additional Document Details')
                    ->schema([
                        FileUpload::make('pan_card')
                            ->label('Pan Card Photo')
                            ->disk('public')
                            ->directory('uploads/documents')
                            ->image()
                            ->maxSize(20 * 1024), // 20 MB

                        FileUpload::make('bank_passbook')
                            ->label('Bank Passbook Photo')
                            ->disk('public')
                            ->directory('uploads/documents')
                            ->image()
                            ->maxSize(20 * 1024), // 20 MB
                    ])->columns(2),

                    Section::make('User Details')
                    ->schema([
                        Forms\Components\Select::make('customer_id')->required()->preload()
                        ->relationship('customer', 'email')
                        ->getOptionLabelFromRecordUsing(function ($record) {
                            return "{$record->first_name} {$record->last_name} ({$record->email})";
                        }),
                        Forms\Components\Select::make('status')->native(false)->required()->options([
                            '0' => 'Procesing',
                            '1' => 'Verified',
                            '2' => 'Rejected'
                        ])
                    ])->columns(2),

            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Label Name'),

                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name'),

                Tables\Columns\TextColumn::make('address_1')
                    ->label('Address 1')
                    ->wrap(),

                    Tables\Columns\TextColumn::make('address_2')
                    ->label('Address 2')
                    ->wrap(),

                    Tables\Columns\TextColumn::make('city')
                    ->label('City')
                    ->wrap(),

                    Tables\Columns\TextColumn::make('state')
                    ->label('State')
                    ->wrap(),

                    Tables\Columns\TextColumn::make('pincode')
                    ->label('Pincode')
                    ->wrap(),

                Tables\Columns\TextColumn::make('mobile_number')
                    ->label('Mobile Number'),

                Tables\Columns\TextColumn::make('email_id')
                    ->label('Email ID'),

                Tables\Columns\ImageColumn::make('aadhar_card_front')
                    ->label('Aadhar Card Front')
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->size(150)
                    ->toggleable()
                    ->url(function ($record) {
                        return asset($record->aadhar_card_front);
                    })
                    ->openUrlInNewTab(),

                Tables\Columns\ImageColumn::make('aadhar_card_back')
                    ->label('Aadhar Card Back')
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->size(150)
                    ->toggleable()
                    ->url(function ($record) {
                        return asset($record->aadhar_card_back);
                    })
                    ->openUrlInNewTab(),
                    
                Tables\Columns\ImageColumn::make('pan_card')
                    ->label('Pan Card Photo')
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->toggleable()
                    ->size(150)
                    ->url(function ($record) {
                        return asset($record->pan_card);
                    })
                    ->openUrlInNewTab(),

                Tables\Columns\ImageColumn::make('bank_passbook')
                    ->label('Bank Passbook Photo')
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->toggleable()
                    ->size(150)
                    ->url(function ($record) {
                        return asset($record->bank_passbook);
                    })
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(function (string $state): string {
                        $colorMap = [
                            '0' => 'warning',
                            '1' => 'success',
                            '2' => 'danger',
                        ];
                        return $colorMap[$state] ?? 'secondary';
                    })
                    ->formatStateUsing(function ($state): string {
                        $stateMap = [
                            '0' => 'Processing',
                            '1' => 'Verified',
                            '2' => 'Rejected',
                        ];
                        return $stateMap[$state] ?? 'Unknown';
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListLabels::route('/'),
            'create' => Pages\CreateLabel::route('/create'),
            'edit' => Pages\EditLabel::route('/{record}/edit'),
        ];
    }
}
