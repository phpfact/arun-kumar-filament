<?php

namespace App\Filament\Customer\Resources\MusicResource\Pages;

use Filament\Actions;
use App\Models\Release;
use Filament\Resources\Components\Tab;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Customer\Resources\MusicResource;

class ListMusic extends ListRecords
{
    protected static string $resource = MusicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // protected function getActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Songs')->icon('heroicon-m-list-bullet')->badge(Release::query()->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'pending' => Tab::make('Pending Songs')->icon('heroicon-m-exclamation-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))->badge(Release::query()->where('status', 'pending')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'approved' => Tab::make('Approved Songs')->icon('heroicon-m-check-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approved'))->badge(Release::query()->where('status', 'approved')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'rejected' => Tab::make('Rejected Songs')->icon('heroicon-m-x-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rejected'))->badge(Release::query()->where('status', 'rejected')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'live' => Tab::make('Live Songs')->icon('heroicon-m-x-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'live'))->badge(Release::query()->where('status', 'live')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
        ];
    }

}
