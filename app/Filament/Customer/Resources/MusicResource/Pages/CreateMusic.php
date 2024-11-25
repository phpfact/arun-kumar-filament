<?php

namespace App\Filament\Customer\Resources\MusicResource\Pages;

use App\Filament\Customer\Resources\MusicResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMusic extends CreateRecord
{
    protected static string $resource = MusicResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     dd($data);

    //     // $data['user_id'] = auth()->id();
    //     return $data;
    // }

    // protected function afterSave()
    // {
    //     parent::afterSave();

    //     // Assuming $this->record is the Release instance being saved.
    //     if ($this->record) {
    //         foreach ($this->data['tracks'] as $trackData) {
    //             $track = new Track($trackData);
    //             $track->release()->associate($this->record);
    //             $track->save();
    //         }
    //     }
    // }

}
