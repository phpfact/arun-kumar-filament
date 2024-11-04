<?php

namespace App\Filament\Resources\BankAccountResource\Pages;

use Filament\Actions;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\BankAccountResource;

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
            'all' => Tab::make('All Bank')->icon('heroicon-m-list-bullet')->badge(BankAccount::query()->count()),
            'pending' => Tab::make('Pending Bank')->icon('heroicon-m-exclamation-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))->badge(BankAccount::query()->where('status', '0')->count()),
            'approved' => Tab::make('Approved Bank')->icon('heroicon-m-check-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approved'))->badge(BankAccount::query()->where('status', '1')->count()),
            'rejected' => Tab::make('Reject Bank')->icon('heroicon-m-x-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rejected'))->badge(BankAccount::query()->where('status', '2')->count()),
        ];
    }
}
