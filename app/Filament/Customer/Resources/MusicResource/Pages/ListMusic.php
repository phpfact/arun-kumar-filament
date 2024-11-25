<?php

namespace App\Filament\Customer\Resources\MusicResource\Pages;

use App\Filament\Customer\Resources\MusicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMusic extends ListRecords
{
    protected static string $resource = MusicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // protected function getActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

}
