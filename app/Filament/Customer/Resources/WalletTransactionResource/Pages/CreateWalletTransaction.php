<?php

namespace App\Filament\Customer\Resources\WalletTransactionResource\Pages;

use App\Filament\Customer\Resources\WalletTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWalletTransaction extends CreateRecord
{
    protected static string $resource = WalletTransactionResource::class;
}
