<?php

namespace App\Filament\Customer\Resources\LabelResource\Pages;

use App\Filament\Customer\Resources\LabelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLabel extends EditRecord
{
    protected static string $resource = LabelResource::class;

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
