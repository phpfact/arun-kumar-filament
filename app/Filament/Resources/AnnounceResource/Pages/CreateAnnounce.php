<?php

namespace App\Filament\Resources\AnnounceResource\Pages;

use App\Filament\Resources\AnnounceResource;
use Filament\Actions;
use App\Models\Customer;
use Filament\Support\Colors\Color;
use Rupadana\FilamentAnnounce\Announce;
use Filament\Resources\Pages\CreateRecord;

class CreateAnnounce extends CreateRecord
{
    protected static string $resource = AnnounceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        if( in_array($data['announceTo'], ['all', 'All Customers']) ){
            $data['announceTo'] = 'all';
        }

        $data['announceToken'] = strtoupper(uniqid());

        if($data['announceTo'] == 'all'){
            Announce::make()
            ->title($data['title'])
            ->icon($data['icon'])
            ->body($data['body'])
            ->disableCloseButton()
            ->actions([])
            ->announceTo(Customer::all());
        }else{

            Announce::make()
            ->title($data['title'])
            ->icon($data['icon'])
            ->body($data['body'])
            ->disableCloseButton()
            ->actions([])
            ->announceTo(Customer::where('id', $data['announceTo'])->get());

        }

        $data['status'] = '1';
        return $data;

    }

}
