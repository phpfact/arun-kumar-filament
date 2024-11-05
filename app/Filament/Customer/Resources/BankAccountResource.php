<?php

namespace App\Filament\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\BankAccount;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Customer\Resources\BankAccountResource\Pages;
use App\Filament\Customer\Resources\BankAccountResource\RelationManagers;

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function canCreate(): bool
    {
        // Check if the current customer has at least one verified bank account
        return !self::userHasVerifiedBankAccount();
    }

    protected static function userHasVerifiedBankAccount(): bool
    {
        return BankAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('status', '1')->exists();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Bank Account Details')
                ->schema([
                    Forms\Components\TextInput::make('account_number')
                        ->numeric()
                        ->required()
                        ->label('Account Number'),
        
                    Forms\Components\Select::make('account_type')
                        ->searchable()
                        ->options([
                            'Savings Account' => 'Savings Account',
                            'Salary Account' => 'Salary Account',
                            'Business Account' => 'Business Account',
                            'Current Account' => 'Current Account',
                            'Trust Account' => 'Trust Account',
                            'Joint Account' => 'Joint Account',
                            'Minor Account' => 'Minor Account',
                            'Corporate Account' => 'Corporate Account',
                            'Student Account' => 'Student Account',
                            'Fixed Deposit' => 'Fixed Deposit',
                            'Recurring Deposit' => 'Recurring Deposit',
                            'NRE Savings' => 'NRE Savings',
                            'NRO Savings' => 'NRO Savings',
                            'FCNR Deposit' => 'FCNR Deposit',
                            'Super Savings' => 'Super Savings',
                            'Zero Balance Account' => 'Zero Balance Account',
                            'Jan Dhan Account' => 'Jan Dhan Account',
                            'Specialized Savings Account' => 'Specialized Savings Account',
                            'Senior Citizen Account' => 'Senior Citizen Account',
                            'Women’s Savings Account' => 'Women’s Savings Account',
                            'Tax Saving Fixed Deposit' => 'Tax Saving Fixed Deposit',
                            'Monthly Income Scheme' => 'Monthly Income Scheme',
                            'Kisan Vikas Patra' => 'Kisan Vikas Patra',
                            'Public Provident Fund' => 'Public Provident Fund',
                            'National Pension System' => 'National Pension System',
                        ])
                        ->default('Savings Account')
                        ->label('Account Type'),
        
                    Forms\Components\TextInput::make('ifsc_code')
                        ->required()
                        ->label('IFSC Code')
                        ->maxLength(150),

                        Forms\Components\TextInput::make('bank_name')
                        ->required()
                        ->label('Bank Name')
                        ->datalist([
                            'State Bank of India', 
                            'HDFC Bank', 
                            'ICICI Bank', 
                            'Axis Bank', 
                            'Punjab National Bank', 
                            'Bank of Baroda', 
                            'Kotak Mahindra Bank', 
                            'Canara Bank', 
                            'Union Bank of India', 
                            'Indian Bank', 
                            'IDBI Bank', 
                            'Yes Bank', 
                            'IndusInd Bank', 
                            'RBL Bank', 
                            'Bandhan Bank', 
                            'Central Bank of India', 
                            'UCO Bank', 
                            'Indian Overseas Bank', 
                            'Bank of Maharashtra', 
                            'DCB Bank',
                            'Jammu & Kashmir Bank',
                            'Federal Bank',
                            'South Indian Bank',
                            'City Union Bank',
                            'Tamilnad Mercantile Bank',
                            'Karur Vysya Bank',
                            'Lakshmi Vilas Bank',
                            'Dhanlaxmi Bank',
                            'Andhra Pradesh Grameena Vikas Bank',
                            'Chaitanya Godavari Grameena Bank',
                            'Prathama UP Gramin Bank',
                            'Saptagiri Grameena Bank',
                            'Vidharbha Konkan Gramin Bank',
                            'Uttar Bihar Gramin Bank',
                            'Odisha Gramya Bank',
                            'Andhra Pragathi Grameena Bank',
                            'Assam Gramin Vikash Bank',
                            'Kerala Gramin Bank',
                            'Madhyanchal Gramin Bank',
                            'Baroda UP Bank',
                            'Punjab Gramin Bank',
                            'Himachal Pradesh Gramin Bank',
                            'Nagaland Rural Bank',
                            'Tripura Gramin Bank',
                            'Vananchal Gramin Bank',
                            'Utkal Grameen Bank',
                            'Madhya Pradesh Gramin Bank',
                            'Manipur Rural Bank',
                            'Puduvai Bharathiar Grama Bank',
                            'Surguja Kshetriya Gramin Bank',
                            'Mizoram Rural Bank',
                            'Meghalaya Rural Bank',
                            'Rajasthan Marudhara Gramin Bank',
                            'Malwa Gramin Bank',
                            'Ujjivan Small Finance Bank',
                            'Equitas Small Finance Bank',
                            'ESAF Small Finance Bank',
                            'Jana Small Finance Bank',
                            'AU Small Finance Bank',
                            'Suryoday Small Finance Bank',
                            'Capital Small Finance Bank',
                            'Fincare Small Finance Bank',
                            'North East Small Finance Bank',
                            'Shivalik Small Finance Bank',
                            'Unity Small Finance Bank',
                            'Standard Chartered Bank',
                            'HSBC Bank',
                            'Citibank',
                            'DBS Bank',
                            'Deutsche Bank',
                            'Bank of America',
                            'JPMorgan Chase Bank',
                            'Barclays Bank',
                            'Royal Bank of Scotland (RBS)',
                            'BNP Paribas',
                            'MUFG Bank',
                            'Mizuho Bank',
                            'Sumitomo Mitsui Banking Corporation',
                            'Societe Generale',
                            'Bank of Tokyo-Mitsubishi UFJ',
                            'Shinhan Bank',
                            'Korea Exchange Bank',
                            'Industrial and Commercial Bank of China (ICBC)',
                            'China Construction Bank',
                            'Woori Bank',
                            'Cathay United Bank',
                            'First Commercial Bank',
                            'Credit Agricole',
                            'Abu Dhabi Commercial Bank',
                            'Mashreq Bank',
                            'Doha Bank',
                            'Qatar National Bank',
                            'Emirates NBD',
                            'National Bank of Oman',
                            'Oman International Bank',
                            'Bank of Bahrain and Kuwait',
                            'Union National Bank',
                            'First Abu Dhabi Bank',
                            'Al Ahli Bank of Kuwait',
                            'American Express Banking Corp.',
                            'Rabobank',
                            'Commonwealth Bank of Australia',
                            'ANZ Banking Group',
                            'Bank of Ceylon',
                            'PT Bank Maybank Indonesia',
                            'Kookmin Bank',
                            'DBS Bank India Limited',
                            'Bandhan Bank',
                            'Utkarsh Small Finance Bank',
                            'AU Small Finance Bank',
                            'Paytm Payments Bank',
                            'India Post Payments Bank',
                            'Airtel Payments Bank',
                            'Fino Payments Bank',
                            'Jio Payments Bank',
                            'Aditya Birla Payments Bank',
                            'NSDL Payments Bank',
                            'Bharti Airtel Limited',
                            'FINO Paytech Limited',
                            'DigiBank by DBS',
                            'SBI Payments',
                            'Rupay Payments',
                            'Amazon Pay',
                            'Google Pay',
                            'WhatsApp Pay',
                            'PhonePe',
                            'HDFC Payment Services Limited',
                            'Axis Payments',
                            'ICICI Payment Services',
                            'Cashfree Payments',
                            'Bajaj Finserv',
                            'Tata Capital Financial Services',
                            'Poonawalla Finance',
                            'Shriram City Union Finance',
                            'Mahindra Finance',
                            'LIC Housing Finance',
                            'PNB Housing Finance',
                            'Reliance Home Finance',
                            'ICICI Home Finance',
                            'HDFC Home Finance',
                            'Indiabulls Housing Finance',
                            'DHFL',
                            'Aditya Birla Finance',
                            'Capital First',
                            'IDFC First Bank',
                            'L&T Finance',
                            'Bharatiya Mahila Bank',
                            'IDFC Bank',
                            'ICICI Prudential Bank',
                            'Tata Cleantech Capital',
                            'HDFC Securities',
                            'Kotak Securities',
                            'Angel Broking',
                            'Sharekhan',
                            'Zerodha',
                            'Upstox',
                            'Groww',
                            '5Paisa',
                            'Geojit',
                            'Motilal Oswal',
                            'Karvy Stock Broking',
                            'Reliance Securities',
                            'JM Financial',
                            'HDFC Mutual Fund',
                            'ICICI Prudential Mutual Fund',
                            'SBI Mutual Fund',
                            'Axis Mutual Fund',
                            'Kotak Mutual Fund',
                            'UTI Mutual Fund',
                            'Tata Mutual Fund',
                            'DSP BlackRock Mutual Fund',
                            'Franklin Templeton',
                            'Invesco Mutual Fund',
                            'LIC Mutual Fund',
                            'L&T Mutual Fund',
                            'Mahindra Mutual Fund',
                            'Quantum Mutual Fund',
                            'Aditya Birla Sun Life Mutual Fund',
                        ])
                        ->placeholder('Enter or select your bank name')
                        ->maxLength(150),
                    
                    Forms\Components\TextInput::make('branch_name')
                        ->required()
                        ->label('Branch Name')
                        ->maxLength(100),
        
                    Forms\Components\TextInput::make('customer_name')
                        ->label('Your Name on ATM card')
                        ->placeholder('Optional')
                        ->maxLength(100),
        
                    Forms\Components\TextInput::make('mobile_number')
                        ->tel()
                        ->placeholder('Optional')
                        ->label('Bank-registered mobile number')
                        ->maxLength(15),
        
                        Forms\Components\TextInput::make('upi_id')
                        ->label('UPI ID')
                        ->placeholder('Enter your UPI ID (Optional)')
                        ->maxLength(100),
                    

                ])->columns(2)
            ]);
    
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(NULL)
            ->modifyQueryUsing(fn (Builder $query) => $query->where('customer_id', Auth::guard('customer')->user()->id))
            ->columns([
                Tables\Columns\TextColumn::make('bank_name')->label('Bank Name'),
                Tables\Columns\TextColumn::make('branch_name')->label('Branch Name'),
                Tables\Columns\TextColumn::make('account_number')->label('Account Number'),
                Tables\Columns\TextColumn::make('ifsc_code')->label('IFSC Code'),
                Tables\Columns\TextColumn::make('account_type')->label('Account Type'),
                Tables\Columns\TextColumn::make('upi_id')->label('UPI ID'),

                Tables\Columns\TextColumn::make('status')->badge()
                ->color(function (string $state): string {
                    $colorMap = [
                        '0' => 'warning',
                        '1' => 'success',
                        '2' => 'danger'
                    ];
                    return $colorMap[$state] ?? 'secondary';
                })
                ->formatStateUsing(function ($state): string {
                    $stateMap = [
                        '0' => 'Processing',
                        '1' => 'Verified',
                        '2' => 'Rejected'
                    ];
                    return $stateMap[$state] ?? 'Unknown';
                })

            ])
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\EditAction::make()
                ->visible(fn ($record) => in_array($record->status, ['0', '2'])),

                Tables\Actions\DeleteAction::make()
                ->visible(fn ($record) => in_array($record->status, ['0', '2'])),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBankAccounts::route('/'),
            'create' => Pages\CreateBankAccount::route('/create'),
            'edit' => Pages\EditBankAccount::route('/{record}/edit'),
        ];
    }
}
