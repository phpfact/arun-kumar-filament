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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['status'] = 'pending';
        $data['reject_reason'] = NULL;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
