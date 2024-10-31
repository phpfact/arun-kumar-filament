<?php

namespace App\Filament\Customer\Resources\SongResource\Pages;

use App\Filament\Customer\Resources\SongResource;
use App\Models\Song;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;

class ListSongs extends ListRecords
{
    protected static string $resource = SongResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add new song'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Songs')->icon('heroicon-m-list-bullet')->badge(Song::query()->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'pending' => Tab::make('Pending Songs')->icon('heroicon-m-exclamation-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))->badge(Song::query()->where('status', 'pending')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'approved' => Tab::make('Approved Songs')->icon('heroicon-m-check-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approved'))->badge(Song::query()->where('status', 'approved')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'rejected' => Tab::make('Rejected Songs')->icon('heroicon-m-x-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rejected'))->badge(Song::query()->where('status', 'rejected')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
        ];
    }

}
