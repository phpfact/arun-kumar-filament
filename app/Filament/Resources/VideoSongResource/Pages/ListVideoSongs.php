<?php

namespace App\Filament\Resources\VideoSongResource\Pages;

use App\Filament\Resources\VideoSongResource;
use App\Models\VideoSong;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;

class ListVideoSongs extends ListRecords
{
    protected static string $resource = VideoSongResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Videos')->icon('heroicon-m-list-bullet')->badge(VideoSong::query()->count()),
            'pending' => Tab::make('Pending Videos')->icon('heroicon-m-exclamation-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))->badge(VideoSong::query()->where('status', 'pending')->count()),
            'approved' => Tab::make('Approved Videos')->icon('heroicon-m-check-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approved'))->badge(VideoSong::query()->where('status', 'approved')->count()),
            'rejected' => Tab::make('Rejected Video')->icon('heroicon-m-x-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rejected'))->badge(VideoSong::query()->where('status', 'rejected')->count()),
        ];
    }

}
