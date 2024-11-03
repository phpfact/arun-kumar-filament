<?php

namespace App\Filament\Customer\Resources\BankAccountResource\Pages;

use App\Filament\Customer\Resources\BankAccountResource;
use App\Models\BankAccount;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;

class ListBankAccounts extends ListRecords
{
    protected static string $resource = BankAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Songs')->icon('heroicon-m-list-bullet')->badge(BankAccount::query()->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'pending' => Tab::make('Pending Songs')->icon('heroicon-m-exclamation-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))->badge(BankAccount::query()->where('status', '0')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'approved' => Tab::make('Approved Songs')->icon('heroicon-m-check-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approved'))->badge(BankAccount::query()->where('status', '1')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'rejected' => Tab::make('Rejected Songs')->icon('heroicon-m-x-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rejected'))->badge(BankAccount::query()->where('status', '2')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
        ];
    }
}
