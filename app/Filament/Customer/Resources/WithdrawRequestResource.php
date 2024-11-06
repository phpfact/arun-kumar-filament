<?php

namespace App\Filament\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use App\Models\WithdrawRequest;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Customer\Resources\WithdrawRequestResource\Pages;
use App\Filament\Customer\Resources\WithdrawRequestResource\RelationManagers;
use Filament\Forms\Components\Textarea;

class WithdrawRequestResource extends Resource
{
    protected static ?string $model = WithdrawRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Section::make('Withdrawal Request')
                ->description('Please enter the amount you wish to withdraw. Ensure it does not exceed the balance available in your account.')
                ->schema([

                    Select::make('bank_id')
                    ->required()
                    ->preload()
                    ->native(false)
                    ->relationship('bank', 'account_number', fn ($query) => $query->where(['status'=>1, 'customer_id'=>getCurrentCustomer()->id]))
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return "Bank: {$record->bank_name}, Account Number: {$record->account_number}, IFSC Code: {$record->ifsc_code}";
                    }),

                    TextInput::make('amount')
                    ->prefix('$')
                    ->numeric()
                    ->required()
                    ->label('Amount')
                    ->rules([
                        fn ($get) => function (string $attribute, $value, $fail) use($get){
                            $customer = Customer::find(getCurrentCustomer()->id);
                            if ($value > $customer->wallet_balance) {
                                $fail("The balance in your account is ". $customer->wallet_balance .". You cannot request a withdrawal greater than this amount.");
                            }
                        },
                    ]),

                    Textarea::make('customer_message')->label('Your Message')->rows(5)->cols(10)

                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(NULL)
            ->modifyQueryUsing(fn ($query) => $query->where(['customer_id' => getCurrentCustomer()->id]))
            ->columns([
                TextColumn::make('amount'),
                TextColumn::make('bank.account_number')->label('Bank AC Number'),
                TextColumn::make('bank.bank_name')->label('Bank Name'),
                TextColumn::make('bank.ifsc_code')->label('IFSC Code'),
                TextColumn::make('status')->badge()->searchable()->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                })
                ->formatStateUsing(fn ($state) => ucfirst($state))
                ->tooltip(function (TextColumn $column, $record): ?string {
                    $state = $column->getState();
                    
                    if ($state === 'rejected') {
                        return $record->reject_reason ?? 'No reason provided';
                    }

                    return null;
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                
                // Tables\Actions\EditAction::make()
                //     ->visible(fn ($record) => in_array($record->status, ['pending','rejected'])),
                    
                // Tables\Actions\DeleteAction::make()
                //     ->visible(fn ($record) => in_array($record->status, ['pending','rejected'])),
                
                Action::make('view_reason')
                ->label('Reason for Rejection')
                ->visible(function ($record) {
                    if ($record->reject_reason) {
                        return true;
                    }
                    return false;
                })
                ->icon('heroicon-o-exclamation-triangle')
                ->color('danger')
                ->modal('Reject Reason')
                ->modalDescription(fn($record) => $record->reject_reason)
                ->modalSubmitAction(false),

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
            'index' => Pages\ListWithdrawRequests::route('/'),
            'create' => Pages\CreateWithdrawRequest::route('/create'),
            // 'edit' => Pages\EditWithdrawRequest::route('/{record}/edit'),
        ];
    }
}
