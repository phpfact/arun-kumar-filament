<?php

namespace App\Filament\Customer\Resources\AnalyticsResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Customer\Resources\AnalyticsResource;

class CreateAnalytics extends CreateRecord
{
    protected static string $resource = AnalyticsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['customer_id'] = Auth::guard('customer')->user()->id;
        return $data;
    }

}
