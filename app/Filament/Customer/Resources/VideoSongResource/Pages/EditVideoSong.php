<?php

namespace App\Filament\Customer\Resources\VideoSongResource\Pages;

use App\Filament\Customer\Resources\VideoSongResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideoSong extends EditRecord
{
    protected static string $resource = VideoSongResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
