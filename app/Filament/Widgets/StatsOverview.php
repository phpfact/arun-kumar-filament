<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Song;
use App\Models\VideoSong;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Customers', Customer::all()->count()),
            Stat::make('Total Songs Uploaded', Song::all()->count()),
            Stat::make('Total Video Songs Uploaded', VideoSong::all()->count()),
        ];
    }
}
