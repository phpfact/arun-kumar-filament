<?php

namespace App\Filament\Customer\Resources\LabelResource\Pages;

use App\Models\Label;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Customer\Resources\LabelResource;

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
            'all' => Tab::make('All Labels')->icon('heroicon-m-list-bullet')->badge(Label::query()->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'processing' => Tab::make('Processing Labels')->icon('heroicon-m-exclamation-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', '0'))->badge(Label::query()->where('status', '0')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'verified' => Tab::make('Verified Labels')->icon('heroicon-m-check-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', '1'))->badge(Label::query()->where('status', '1')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
            'rejected' => Tab::make('Rejected Labels')->icon('heroicon-m-x-circle')->modifyQueryUsing(fn (Builder $query) => $query->where('status', '2'))->badge(Label::query()->where('status', '2')->where('customer_id', Auth::guard('customer')->user()->id)->count()),
        ];
    }
    
}
