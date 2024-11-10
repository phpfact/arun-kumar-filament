<?php

namespace App\Filament\Resources\WithdrawRequestResource\Pages;

use App\Filament\Resources\WithdrawRequestResource;
use App\Models\WalletTransaction;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWithdrawRequest extends EditRecord
{
    protected static string $resource = WithdrawRequestResource::class;

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['status'] == 'approved') {
            WalletTransaction::create([
                'transaction_id'  => strtoupper(uniqid()),
                'customer_id'     => $data['customer_id'],
                'type'            => 'withdraw',
                'amount'          => $data['amount'],
                'remark'          => $data['remark'],
            ]);
        }

        refreshWallet( $data['customer_id'] );
        return $data;
    }

}
