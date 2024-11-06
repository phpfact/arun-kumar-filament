<?php

namespace App\Filament\Customer\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Wallet Balance', '$ '.number_format(getCurrentCustomer()->wallet_balance)),
            Stat::make('My Songs', getCurrentCustomer()->songs->count()),
            Stat::make('My Video Songs', getCurrentCustomer()->videoSongs->count()),
        ];
    }
}
