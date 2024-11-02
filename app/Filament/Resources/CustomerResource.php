<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextInputColumn;
use App\Filament\Resources\CustomerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerResource\RelationManagers;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('User Details')
                    ->schema([
                        TextInput::make('first_name')
                            ->label('First Name'),

                        TextInput::make('last_name')
                            ->label('Last Name'),

                        // TextInput::make('label_name')
                        //     ->required()
                        //     ->unique(ignoreRecord: true)
                        //     ->label('Label Name'),

                        // TextInput::make('father_first_name')
                        //     ->label('Father\'s First Name'),

                        // TextInput::make('father_last_name')
                        //     ->label('Father\'s Last Name'),

                        // TextInput::make('mother_first_name')
                        //     ->label('Mother\'s First Name'),

                        // TextInput::make('mother_last_name')
                        //     ->label('Mother\'s Last Name'),

                        // Select::make('plan')
                        //     ->selectablePlaceholder(false)
                        //     ->options([
                        //         'free' => 'Free',
                        //         'gold' => 'Gold',
                        //     ])

                    ]),

                // Fieldset::make('Address')
                //     ->relationship('address')
                //     ->columns(2)
                //     ->schema([
                //         TextInput::make('address1')
                //             ->label('Address Line 1'),

                //         TextInput::make('address2')
                //             ->label('Address Line 2'),

                //         Grid::make(3)
                //             ->schema([
                //                 TextInput::make('city')
                //                     ->label('City'),

                //                 TextInput::make('state')
                //                     ->label('State'),

                //                 TextInput::make('country')
                //                     ->formatStateUsing(fn ($state) => $state ?? "India")
                //                     ->readOnly()
                //                     ->label('Country'),

                //             ]),
                //     ]),

                Fieldset::make('Contact Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('phone')
                            ->rules(['numeric'])
                            ->label('Phone Number'),

                        TextInput::make('whatsapp')
                            ->rules(['numeric'])
                            ->label('Whatsapp Number'),

                        TextInput::make('email')
                            ->required()
                            ->email(),

                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->revealable()
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->formatStateUsing(function ($state) {
                                return '';
                            }),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->label('First Name'),

                TextColumn::make('last_name')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->label('Last Name'),

                TextColumn::make('email')
                    ->toggleable()
                    ->icon('heroicon-m-envelope')
                    ->iconColor('warning')
                    ->placeholder('N/A')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->toggleable()
                    ->icon('heroicon-m-phone')
                    ->iconColor('success')
                    ->placeholder('N/A')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('whatsapp')
                    ->toggleable()
                    ->icon('heroicon-m-phone')
                    ->iconColor('success')
                    ->placeholder('N/A')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('dob')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->placeholder('N/A')
                    ->label('Date of Birth'),

                TextColumn::make('father_first_name')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->placeholder('N/A')
                    ->label('Father\'s First Name'),

                TextColumn::make('father_last_name')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->placeholder('N/A')
                    ->label('Father\'s Last Name'),

                TextColumn::make('mother_first_name')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->placeholder('N/A')
                    ->label('Mother\'s First Name'),

                TextColumn::make('mother_last_name')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->placeholder('N/A')
                    ->label('Mother\'s Last Name'),

                TextColumn::make('address.address1')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->placeholder('N/A')
                    ->label('Address Line 1'),

                TextColumn::make('address.address2')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->placeholder('N/A')
                    ->label('Address Line 2'),

                TextColumn::make('address.city')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->placeholder('N/A')
                    ->label('City'),

                TextColumn::make('address.state')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->placeholder('N/A')
                    ->label('State'),

                TextColumn::make('address.country')
                    ->searchable()
                    ->sortable()
                    ->placeholder('N/A')
                    ->toggleable()
                    ->label('Country'),

                TextInputColumn::make('wallet_balance')
                    ->rules(['numeric', 'gte:0'])
                    ->sortable()
                    ->toggleable()
                    ->label('Wallet Balance'),

                TextColumn::make('created_at')
                    ->sortable()
                    ->toggleable()
                    ->date('M d, Y h:i A')
                    ->label('Registered At'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('update_wallet_balance')
                    ->label('Update wallet balance')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function () {
                        updateWallet();
                        Notification::make()
                            ->title('Wallet balance updated!')
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListCustomers::route('/'),
            // 'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
