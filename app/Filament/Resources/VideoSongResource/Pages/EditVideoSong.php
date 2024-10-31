<?php

namespace App\Filament\Resources\VideoSongResource\Pages;

use App\Filament\Resources\VideoSongResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideoSong extends EditRecord
{
    protected static string $resource = VideoSongResource::class;

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
