<?php

namespace App\Filament\Resources\SongResource\Pages;

use App\Models\Song;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\SongResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSongs extends ListRecords
{
    protected static string $resource = SongResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Songs')->icon('heroicon-m-list-bullet')->badge(Song::query()->count()),
            'pending' => Tab::make('Pending Songs')->icon('heroicon-m-exclamation-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))->badge(Song::query()->where('status', 'pending')->count()),
            'approved' => Tab::make('Approved Songs')->icon('heroicon-m-check-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approved'))->badge(Song::query()->where('status', 'approved')->count()),
            'rejected' => Tab::make('Rejected Songs')->icon('heroicon-m-x-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rejected'))->badge(Song::query()->where('status', 'rejected')->count()),
        ];
    }

}
