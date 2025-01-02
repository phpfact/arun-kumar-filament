<?php

namespace App\Filament\Customer\Widgets;

use App\Models\Release;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            // Stat::make('Wallet Balance', '$ ' . number_format(getCurrentCustomer()->wallet_balance, 2))
            // ->url(URL::to('/customer/wallet-transactions')),

            // Stat::make('Wallet Balance', null)->view('filament.widgets.withdraw-button'),

            Stat::make('Wallet Balance', null)->view('filament.widgets.withdraw-button', [
                    'walletBalance' => getCurrentCustomer()->wallet_balance,
            ]),
            // Stat::make('My Songs', getCurrentCustomer()->songs->count()),
            Stat::make('My Songs', Release::where(['customer_id' => Auth::guard('customer')->user()->id])->get()->count()),
            Stat::make('My Video Songs', getCurrentCustomer()->videoSongs->count()),
        ];
    }
}