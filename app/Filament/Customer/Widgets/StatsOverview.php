<?php

namespace App\Filament\Customer\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\URL;

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
            Stat::make('My Songs', getCurrentCustomer()->songs->count()),
            Stat::make('My Video Songs', getCurrentCustomer()->videoSongs->count()),
        ];
    }
}