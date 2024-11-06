<?php

namespace App\Filament\Resources\WalletTransactionResource\Pages;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\WalletTransactionResource;

class CreateWalletTransaction extends CreateRecord
{
    protected static string $resource = WalletTransactionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function handleRecordCreation( array $data ): Model
    {
        // dd($data); 
        $customer = Customer::find( $data['customer_id'] );
        if($customer){
            if($data['type'] == 'deposit'){
                $customer->wallet_balance += $data['amount'];
            }else{
                $customer->wallet_balance -= $data['amount'];
            }
            $customer->save();
        }
        return static::getModel()::create( $data );
    }
}
