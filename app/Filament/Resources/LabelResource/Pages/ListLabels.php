<?php

namespace App\Filament\Resources\LabelResource\Pages;

use App\Filament\Resources\LabelResource;
use Filament\Actions;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;

class ListLabels extends ListRecords
{
    protected static string $resource = LabelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Labels')->icon('heroicon-m-list-bullet')->badge(Label::query()->count()),
            'processing' => Tab::make('Processing Labels')->icon('heroicon-m-exclamation-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', '0'))->badge(Label::query()->where('status', '0')->count()),
            'verified' => Tab::make('Verified Labels')->icon('heroicon-m-check-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', '1'))->badge(Label::query()->where('status', '1')->count()),
            'rejected' => Tab::make('Rejected Labels')->icon('heroicon-m-x-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', '2'))->badge(Label::query()->where('status', '2')->count()),
        ];
    }

}
