<?php

namespace App\Filament\Customer\Resources\ArtistsResource\Pages;

use App\Filament\Customer\Resources\ArtistsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtists extends EditRecord
{
    protected static string $resource = ArtistsResource::class;

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
