<?php

namespace App\Filament\Customer\Resources\WithdrawRequestResource\Pages;

use App\Filament\Customer\Resources\WithdrawRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWithdrawRequest extends CreateRecord
{
    protected static string $resource = WithdrawRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['customer_id'] = getCurrentCustomer()->id;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
