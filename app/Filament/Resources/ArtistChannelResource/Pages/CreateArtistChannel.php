<?php

namespace App\Filament\Resources\ArtistChannelResource\Pages;

use App\Filament\Resources\ArtistChannelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArtistChannel extends CreateRecord
{
    protected static string $resource = ArtistChannelResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
}
