<?php

namespace App\Filament\Customer\Resources\RemoveCopyrightRequestResource\Pages;

use App\Filament\Customer\Resources\RemoveCopyrightRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRemoveCopyrightRequest extends CreateRecord
{
    protected static string $resource = RemoveCopyrightRequestResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
}
