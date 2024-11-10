<?php

namespace App\Filament\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Customer\Resources\WalletTransactionResource\Pages;
use App\Filament\Customer\Resources\WalletTransactionResource\RelationManagers;

class WalletTransactionResource extends Resource
{
    protected static ?string $model = WalletTransaction::class;

    protected static ?string $modelLabel = 'Payment History';

    protected static ?string $pluralModelLabel = 'Payment Historys';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(NULL)
            ->modifyQueryUsing(fn (Builder $query) => $query->where('customer_id', Auth::guard('customer')->user()->id))
            ->columns([
                TextColumn::make('transaction_id')->label('Transaction ID'),
                TextColumn::make('amount')->prefix('$ ')->label('Amount'),
                TextColumn::make('type')->label('Transaction Type'),
                TextColumn::make('remark')->label('Remark'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make()
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
            // 'create' => Pages\CreateWalletTransaction::route('/create'),
            // 'edit' => Pages\EditWalletTransaction::route('/{record}/edit'),
        ];
    }
}
