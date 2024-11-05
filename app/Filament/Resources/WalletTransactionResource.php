<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\WalletTransaction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WalletTransactionResource\Pages;
use App\Filament\Resources\WalletTransactionResource\RelationManagers;

class WalletTransactionResource extends Resource
{
    protected static ?string $model = WalletTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('customer_id')
                ->relationship('customer', 'email')
                ->searchable()
                ->preload()
                ->label('Select Customer')
                ->required(),

                Select::make('type')
                ->label('Transaction Type')
                ->options([
                    'deposit' => 'Deposit',
                    'withdraw' => 'Withdraw',
                ]),

                TextInput::make('amount')
                ->prefix('Rs.')
                ->numeric()
                ->required()
                ->label('Amount')
                ->rules([
                    fn ($get) => function (string $attribute, $value, $fail) use($get){
                        $customer = Customer::find($get('customer_id'));
                        if ($value > $customer->wallet_balance && $get('type') == 'withdraw') {
                            $fail('The amount must be less than or equal to '.$customer->wallet_balance.'.');
                        }
                    },
                ]),

                Textarea::make('remark')
                ->columnSpanFull()
                ->label('Remark'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(NULL)
            ->columns([
                TextColumn::make('customer.first_name')->label('Name'),
                TextColumn::make('customer.email')->label('Customer Mail'),
                TextColumn::make('amount')->prefix('Rs.')->label('Amount'),
                TextColumn::make('type')->label('Transaction Type'),
            ])
            ->filters([
                SelectFilter::make('customer_id')
                ->label('Customer')
                ->searchable()
                ->preload()
                ->multiple()
                    ->relationship('customer', 'email')
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListWalletTransactions::route('/'),
            'create' => Pages\CreateWalletTransaction::route('/create'),
            'edit' => Pages\EditWalletTransaction::route('/{record}/edit'),
        ];
    }
}
