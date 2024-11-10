<?php

namespace App\Filament\Customer\Resources\WithdrawRequestResource\Pages;

use Filament\Actions;
use App\Models\WithdrawRequest;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Customer\Resources\WithdrawRequestResource;

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

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // Check if there's already a pending request for this customer
    //     $existingRequest = WithdrawRequest::where('customer_id', getCurrentCustomer()->id)->where('status', 'pending')->first();
    //     if ($existingRequest) {
    //         throw new \Exception('You already have a pending withdrawal request. Please wait until it is processed before making another request.');
    //     }


    //     $data['customer_id'] = getCurrentCustomer()->id;
    //     return $data;
    // }

}
