<?php

namespace App\Filament\Customer\Pages\Auth;

use Filament\Pages\Page;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as AuthRegister;

class Register extends AuthRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([

                        TextInput::make('first_name')
                        ->required()
                        ->label('First Name'),

                        TextInput::make('last_name')
                        ->required()
                        ->label('Last Name'),

                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        // $this->getRoleFormComponent(), 
                    ])
                    ->statePath('data'),
            ),
        ];
    }
 
    // protected function getRoleFormComponent(): Component
    // {
    //     return Select::make('role')
    //         ->options([
    //             'buyer' => 'Buyer',
    //             'seller' => 'Seller',
    //         ])
    //         ->default('buyer')
    //         ->required();
    // }
}
