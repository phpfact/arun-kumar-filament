<?php

namespace App\Filament\Pages;

use App\Models\Settings;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Artisan;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class Setting extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.setting';

    protected static ?string $slug = 'settings';

    protected static ?string $navigationLabel = 'Settings';

    protected ?string $heading = 'Settings';


    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->submit('save'),

            Action::make('clear_cache')
                ->label('Clear Cache')
                ->color('success')
                ->action('clear_cache'),

        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Company Details')
                    ->schema([

                        RichEditor::make('address')
                            ->columnSpanFull()
                            ->label('Full Address')
                            ->default(
                                Settings::where('key', 'address')->pluck('value')->first()
                            ),

                        TextInput::make('email')
                            ->email()
                            ->default(
                                Settings::where('key', 'email')->pluck('value')->first()
                            ),

                        TextInput::make('phone')
                            ->label('Mobile Number')
                            ->default(
                                Settings::where('key', 'phone')->pluck('value')->first()
                            ),

                        TextInput::make('telephone')
                            ->label('Telephone Number')
                            ->tel()
                            ->default(
                                Settings::where('key', 'telephone')->pluck('value')->first()
                            ),

                        FileUpload::make('logo')
                            ->required()
                            ->disk('public')
                            ->directory('assets/uploads')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(512)
                            ->preserveFilenames()
                            ->default(
                                Settings::where('key', 'logo')->pluck('value')->first()
                            )
                            ->label('Logo'),
                    ])
                    ->collapsible()
                    ->columns(3),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {

            $data = $this->form->getState();
            foreach ($data as $key => $value) {
                Settings::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
            }

            Notification::make()
                ->title('Saved successfully')
                ->body('If the settings are not reflected, please perform a hard refresh on the project.')
                ->success()
                ->send();
        } catch (Halt $exception) {
            return;
        }
    }
    public function clear_cache(): void
    {
        try {

            Artisan::call('optimize:clear');

            Notification::make()
                ->title('Cache cleared successfully')
                ->body('Cache, config, routes, and views have been cleared.')
                ->success()
                ->send();
        } catch (Halt $exception) {
            return;
        }
    }
}
