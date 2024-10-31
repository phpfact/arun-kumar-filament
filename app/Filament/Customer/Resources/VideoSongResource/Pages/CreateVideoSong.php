<?php

namespace App\Filament\Customer\Resources\VideoSongResource\Pages;

use App\Filament\Customer\Resources\VideoSongResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVideoSong extends CreateRecord
{
    protected static string $resource = VideoSongResource::class;

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
