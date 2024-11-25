<?php

namespace App\Filament\Customer\Resources\MusicResource\Pages;

use App\Filament\Customer\Resources\MusicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMusic extends EditRecord
{
    protected static string $resource = MusicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
}
