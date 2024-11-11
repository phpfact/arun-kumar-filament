<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\WalletTransaction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
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

                Section::make('')
                ->schema([

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

                    TextInput::make('amount')
                    ->prefix('$')
                    ->numeric()
                    ->maxValue(500000)
                    ->required()
                    ->label('Amount')
                    ->rules([
                        fn ($get) => function (string $attribute, $value, $fail) use($get){
                            if($get('customer_id')){
                                $customer = Customer::find($get('customer_id'));
                                if ($value > $customer->wallet_balance && $get('type') == 'withdraw') {
                                    $fail('The amount must be less than or equal to $'.$customer->wallet_balance.'.');
                                }
                            }
                        },
                    ]),

                    Select::make('type')
                    ->label('Transaction Type')
                    ->required()
                    ->native(false)
                    ->options([
                        'deposit' => 'Deposit',
                        'withdraw' => 'Withdraw',
                    ]),

                    Textarea::make('remark')->columnSpanFull()->required()->autosize()->cols(10)->rows(10)->label('Admin Remark')->placeholder('Enter the purpose of the transaction.'),

                ])->columns(3)
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(NULL)
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('id', 'asc'))
            ->columns([
                TextColumn::make('transaction_id')->label('Transaction ID'),
                TextColumn::make('customer_full_name')->label('Full Name')->getStateUsing(fn (Model $record) => $record->customer->first_name . ' ' . $record->customer->last_name),
                TextColumn::make('customer.email')->label('Customer Mail'),
                TextColumn::make('amount')->prefix('$ ')->label('Amount'),
                TextColumn::make('type')->label('Transaction Type')->formatStateUsing(fn ($state) => ucfirst($state))->badge()->color(fn ($state) => $state === 'deposit' ? 'success' : ($state === 'withdraw' ? 'warning' : ''))
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
