<?php

namespace App\Filament\Customer\Resources\ArtistChannelResource\Pages;

use App\Filament\Customer\Resources\ArtistChannelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArtistChannel extends CreateRecord
{
    protected static string $resource = ArtistChannelResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['customer_id'] = auth('customer')->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
