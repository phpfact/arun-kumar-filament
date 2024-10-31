<?php

namespace App\Filament\Resources\ArtistChannelResource\Pages;

use App\Filament\Resources\ArtistChannelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtistChannels extends ListRecords
{
    protected static string $resource = ArtistChannelResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
