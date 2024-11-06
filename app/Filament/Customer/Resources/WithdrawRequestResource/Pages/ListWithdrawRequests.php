<?php

namespace App\Filament\Customer\Resources\WithdrawRequestResource\Pages;

use App\Filament\Customer\Resources\WithdrawRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWithdrawRequests extends ListRecords
{
    protected static string $resource = WithdrawRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
