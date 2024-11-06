<?php

namespace App\Filament\Resources\ArtistChannelResource\Pages;

use App\Filament\Resources\ArtistChannelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtistChannel extends EditRecord
{
    protected static string $resource = ArtistChannelResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
}
