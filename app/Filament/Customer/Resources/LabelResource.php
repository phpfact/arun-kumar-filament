<?php

namespace App\Filament\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Label;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Customer\Resources\LabelResource\Pages;

class LabelResource extends Resource
{
    protected static ?string $model = Label::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                        ->label('Full Name')
                        ->required(),

                    Forms\Components\TextInput::make('mobile_number')
                        ->label('Mobile Number')
                        ->required()
                        ->numeric()
                        ->maxlength(10)
                        ->minlength(10),

                    Forms\Components\TextInput::make('email_id')
                        ->label('Email ID')
                        ->email()
                        ->required(),

                    Forms\Components\TextInput::make('address_1')
                        ->label('Address Line 1')
                        ->required(),

                    Forms\Components\TextInput::make('address_2')
                        ->label('Address Line 2'),

                    Forms\Components\TextInput::make('city')
                        ->label('City')
                        ->required(),

                    Forms\Components\TextInput::make('state')
                        ->label('State')
                        ->required(),

                    Forms\Components\TextInput::make('pincode')
                        ->label('Pincode')
                        ->required()
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
                            ->maxSize(20 * 1024) // 20 MB
                            ->required(),

                        FileUpload::make('aadhar_card_back')
                            ->label('Aadhar Card Back Photo')
                            ->disk('public')
                            ->directory('uploads/documents')
                            ->image()
                            ->maxSize(20 * 1024) // 20 MB
                            ->required(),
                    ])->columns(2),

                Section::make('Additional Document Details')
                    ->schema([
                        FileUpload::make('pan_card')
                            ->label('Pan Card Photo')
                            ->disk('public')
                            ->directory('uploads/documents')
                            ->image()
                            ->maxSize(20 * 1024) // 20 MB
                            ->required(),

                        FileUpload::make('bank_passbook')
                            ->label('Bank Passbook Photo')
                            ->disk('public')
                            ->directory('uploads/documents')
                            ->image()
                            ->maxSize(20 * 1024) // 20 MB
                            ->required(),
                    ])->columns(2),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->where('customer_id', Auth::guard('customer')->user()->id))
            ->checkIfRecordIsSelectableUsing(fn (Model $record): bool => false)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Label Name')
                    ->disableClick(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->disableClick()
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

                Tables\Actions\EditAction::make()
                ->visible(fn ($record) => in_array($record->status, ['0', '2'])),

                Tables\Actions\DeleteAction::make()
                ->visible(fn ($record) => in_array($record->status, ['0', '2'])),

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
