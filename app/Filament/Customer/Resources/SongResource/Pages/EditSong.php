<?php

namespace App\Filament\Customer\Resources\SongResource\Pages;

use App\Filament\Customer\Resources\SongResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSong extends EditRecord
{
    protected static string $resource = SongResource::class;

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['status'] = 'pending';
        $data['reject_reason'] = '';
        return $data;
    }

}
