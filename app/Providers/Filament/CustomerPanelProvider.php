<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Enums\ThemeMode;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Navigation\NavigationItem;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use App\Filament\Customer\Pages\Auth\Register;
use Illuminate\Session\Middleware\StartSession;
use App\Filament\Customer\Widgets\StatsOverview;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\Customer\Pages\Auth\EditProfile;
use App\Filament\Customer\Resources\SongResource;
use App\Filament\Customer\Resources\LabelResource;
use App\Filament\Customer\Resources\MusicResource;
use Afsakar\FilamentOtpLogin\FilamentOtpLoginPlugin;
use App\Filament\Customer\Resources\ArtistsResource;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Rupadana\FilamentAnnounce\FilamentAnnouncePlugin;
use App\Filament\Customer\Resources\AnalyticsResource;
use App\Filament\Customer\Resources\VideoSongResource;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Customer\Resources\BankAccountResource;
use Filament\Http\Middleware\DisableBladeIconComponents;
use App\Filament\Customer\Resources\ArtistChannelResource;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Filament\Customer\Resources\WithdrawRequestResource;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use App\Filament\Customer\Resources\WalletTransactionResource;
use App\Filament\Customer\Resources\RemoveCopyrightRequestResource;
use App\Filament\Customer\Resources\SongResource\Widgets\LatestSongs;

class CustomerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('customer')
            ->path('customer')
            ->login()
            // ->registration(Register::class)
            ->passwordReset()
            ->colors([
                'primary' => Color::Amber,
            ])
            // ->brandLogo(asset('assets/images/resources/logo/favicon.png'))
            ->brandLogo(asset(settings('logo')))
            ->favicon(asset(settings('logo')))
            ->brandLogoHeight('4rem')
            ->homeUrl('/')
            ->plugin(
                FilamentOtpLoginPlugin::make(),
                FilamentAnnouncePlugin::make()
                    ->pollingInterval('30s') // optional, by default it is set to null
                    ->defaultColor(Color::Blue) // optional, by default it is set to "primary"
            )
            ->maxContentWidth(MaxWidth::Full)
            ->profile(EditProfile::class, false)
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([
                    NavigationItem::make('Dashboard')
                        ->icon('heroicon-o-home')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                        ->url(fn (): string => Dashboard::getUrl()),
                    ...LabelResource::getNavigationItems(),
                    ...ArtistsResource::getNavigationItems(),
                    ...MusicResource::getNavigationItems(),
                    ...SongResource::getNavigationItems(),
                    ...VideoSongResource::getNavigationItems(),
                    ...RemoveCopyrightRequestResource::getNavigationItems(),
                    ...AnalyticsResource::getNavigationItems(),
                    ...BankAccountResource::getNavigationItems(),
                    ...WithdrawRequestResource::getNavigationItems(),
                    ...WalletTransactionResource::getNavigationItems()
                    // ...ArtistChannelResource::getNavigationItems(),
                    // ...RoleResource::getNavigationItems(),
                    // ...UserResource::getNavigationItems(),
                ]);
            })
            ->discoverResources(in: app_path('Filament/Customer/Resources'), for: 'App\\Filament\\Customer\\Resources')
            ->discoverPages(in: app_path('Filament/Customer/Pages'), for: 'App\\Filament\\Customer\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Customer/Widgets'), for: 'App\\Filament\\Customer\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                StatsOverview::class,
                LatestSongs::class
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authGuard('customer')
            ->authPasswordBroker('customers')
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
