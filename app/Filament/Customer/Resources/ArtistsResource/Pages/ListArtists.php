<?php

namespace App\Filament\Customer\Resources\ArtistsResource\Pages;

use App\Filament\Customer\Resources\ArtistsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtists extends ListRecords
{
    protected static string $resource = ArtistsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
