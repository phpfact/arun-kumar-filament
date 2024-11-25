<?php

namespace App\Filament\Resources\AnnounceResource\Pages;

use App\Filament\Resources\AnnounceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnnounces extends ListRecords
{
    protected static string $resource = AnnounceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
