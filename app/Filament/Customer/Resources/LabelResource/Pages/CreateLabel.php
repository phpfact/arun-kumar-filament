<?php

namespace App\Filament\Customer\Resources\LabelResource\Pages;

use App\Filament\Customer\Resources\LabelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLabel extends CreateRecord
{
    protected static string $resource = LabelResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['customer_id'] = auth()->id();
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
}
