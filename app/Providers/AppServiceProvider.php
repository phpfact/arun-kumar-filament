<?php

namespace App\Providers;

use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Table::configureUsing(function (Table $table): void {
            
        //     $table
        //         ->poll('2s')
        //         ->striped()
        //         ->paginationPageOptions([10, 25, 50, 100, 150, 'all']);
        // });
    }
}
