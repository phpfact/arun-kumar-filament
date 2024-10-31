<?php

namespace App\Filament\Customer\Resources\ArtistChannelResource\Pages;

use App\Filament\Customer\Resources\ArtistChannelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtistChannels extends ListRecords
{
    protected static string $resource = ArtistChannelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['customer_id'] = auth('customer')->id();
                    return $data;
                }),
        ];
    }
}
