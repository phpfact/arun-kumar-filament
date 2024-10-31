<?php

namespace App\Filament\Customer\Resources\SongResource\Pages;

use App\Filament\Customer\Resources\SongResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSong extends CreateRecord
{
    protected static string $resource = SongResource::class;

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
