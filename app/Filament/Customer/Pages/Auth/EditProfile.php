<?php

namespace App\Filament\Customer\Pages\Auth;

use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected static ?string $model = Customer::class;

    public function form(Form $form): Form
    {
        return $form
            ->inlineLabel(false)
            ->schema([
                Fieldset::make('User Details')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->label('First Name'),

                        TextInput::make('last_name')
                            ->label('Last Name'),

                        // TextInput::make('father_first_name')
                        //     ->required()
                        //     ->label('Father\'s First Name'),

                        // TextInput::make('father_last_name')
                        //     ->label('Father\'s Last Name'),

                        // TextInput::make('mother_first_name')
                        //     ->required()
                        //     ->label('Mother\'s First Name'),

                        // TextInput::make('mother_last_name')
                        //     ->label('Mother\'s Last Name'),

                    ]),

                // Fieldset::make('Address')
                //     ->relationship('address')
                //     ->columns(2)
                //     ->schema([
                //         TextInput::make('address1')
                //             ->required()
                //             ->label('Address Line 1'),

                //         TextInput::make('address2')
                //             ->required()
                //             ->label('Address Line 2'),

                //         Grid::make(3)
                //             ->schema([
                //                 TextInput::make('city')
                //                     ->required()
                //                     ->label('City'),

                //                 TextInput::make('state')
                //                     ->required()
                //                     ->label('State'),

                //                 TextInput::make('country')
                //                     ->formatStateUsing(fn ($state) => $state ?? "India")
                //                     ->readOnly()
                //                     ->required()
                //                     ->label('Country'),

                //             ]),



                //     ]),

                Fieldset::make('Contact Details')
                    ->columns(3)
                    ->schema([
                        TextInput::make('phone')
                            ->required()
                            ->rules(['numeric'])
                            ->label('Phone Number'),

                        TextInput::make('whatsapp')
                            ->required()
                            ->rules(['numeric'])
                            ->label('Whatsapp Number'),

                        $this->getEmailFormComponent(),
                    ]),

                // Fieldset::make('Documents')
                //     ->columns(3)
                //     ->schema([
                //         FileUpload::make('aadhar_card_front')
                //             ->required()
                //             ->disk('public')
                //             ->directory('assets/uploads/documents')
                //             ->image()
                //             ->imageEditor()
                //             ->imageEditorAspectRatios([
                //                 '16:9',
                //                 '4:3',
                //                 '1:1',
                //             ])
                //             ->maxSize(512)
                //             ->preserveFilenames()
                //             ->label('Upload Aadhar Card (Front Side)'),

                //         FileUpload::make('aadhar_card_back')
                //             ->required()
                //             ->disk('public')
                //             ->directory('assets/uploads/documents')
                //             ->image()
                //             ->imageEditor()
                //             ->imageEditorAspectRatios([
                //                 '16:9',
                //                 '4:3',
                //                 '1:1',
                //             ])
                //             ->maxSize(512)
                //             ->preserveFilenames()
                //             ->label('Upload Aadhar Card (Back Side)'),

                //         FileUpload::make('pancard')
                //             ->required()
                //             ->disk('public')
                //             ->directory('assets/uploads/documents')
                //             ->image()
                //             ->imageEditor()
                //             ->imageEditorAspectRatios([
                //                 '16:9',
                //                 '4:3',
                //                 '1:1',
                //             ])
                //             ->maxSize(512)
                //             ->preserveFilenames()
                //             ->label('Upload PAN Card'),
                //     ]),

                Fieldset::make('Change Password')
                    ->columns('auto-fit')
                    ->schema([
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ]),


                  Fieldset::make('Secure Login')
                      ->columns('auto-fit')
                      ->schema([
                          ToggleButtons::make('email_two_factor')
                              ->label('Email OTP for Two-Factor Authentication ?')
                              ->boolean()
                              ->grouped()
                  ]),

            ]);
    }
}
