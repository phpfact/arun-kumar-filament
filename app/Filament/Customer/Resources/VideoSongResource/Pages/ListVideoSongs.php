<?php

namespace App\Filament\Customer\Resources\VideoSongResource\Pages;

use Filament\Actions;
use App\Models\VideoSong;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Customer\Resources\VideoSongResource;

class ListVideoSongs extends ListRecords
{
    protected static string $resource = VideoSongResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Videos')->icon('heroicon-m-list-bullet')->badge(VideoSong::query()->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'pending' => Tab::make('Pending Videos')->icon('heroicon-m-exclamation-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))->badge(VideoSong::query()->where('status', 'pending')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'approved' => Tab::make('Approved Videos')->icon('heroicon-m-check-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approved'))->badge(VideoSong::query()->where('status', 'approved')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'rejected' => Tab::make('Rejected Video')->icon('heroicon-m-x-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rejected'))->badge(VideoSong::query()->where('status', 'rejected')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
        ];
    }

}
