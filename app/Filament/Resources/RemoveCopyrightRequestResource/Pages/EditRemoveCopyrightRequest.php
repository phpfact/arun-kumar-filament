<?php

namespace App\Filament\Resources\RemoveCopyrightRequestResource\Pages;

use App\Filament\Resources\RemoveCopyrightRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRemoveCopyrightRequest extends EditRecord
{
    protected static string $resource = RemoveCopyrightRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
