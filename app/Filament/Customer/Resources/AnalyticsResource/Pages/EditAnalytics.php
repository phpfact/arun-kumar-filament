<?php

namespace App\Filament\Customer\Resources\AnalyticsResource\Pages;

use App\Filament\Customer\Resources\AnalyticsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnalytics extends EditRecord
{
    protected static string $resource = AnalyticsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}