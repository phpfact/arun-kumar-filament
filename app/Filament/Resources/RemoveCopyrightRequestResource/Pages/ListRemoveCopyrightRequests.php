<?php

namespace App\Filament\Resources\RemoveCopyrightRequestResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use App\Models\RemoveCopyrightRequest;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RemoveCopyrightRequestResource;

class ListRemoveCopyrightRequests extends ListRecords
{
    protected static string $resource = RemoveCopyrightRequestResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Claim')->icon('heroicon-m-list-bullet')->badge(RemoveCopyrightRequest::query()->count()),
            'pending' => Tab::make('Pending Claim')->icon('heroicon-m-exclamation-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))->badge(RemoveCopyrightRequest::query()->where('status', 'pending')->count()),
            'processing' => Tab::make('Processing Claim')->icon('heroicon-m-exclamation-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'processing'))->badge(RemoveCopyrightRequest::query()->where('status', 'processing')->count()),
            'completed' => Tab::make('Approved Claim')->icon('heroicon-m-check-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed'))->badge(RemoveCopyrightRequest::query()->where('status', 'completed')->count()),
            'cancelled' => Tab::make('Rejected Claim')->icon('heroicon-m-x-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'cancelled'))->badge(RemoveCopyrightRequest::query()->where('status', 'cancelled')->count()),
        ];
    }

}
