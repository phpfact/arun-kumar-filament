<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use App\Filament\Pages\Setting;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\SongResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\LabelResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\AnalyticsResource;
use App\Filament\Resources\VideoSongResource;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\Resources\ArtistChannelResource;
use App\Filament\Resources\BankAccountResource;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use App\Filament\Resources\RemoveCopyrightRequestResource;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandLogo(asset(settings('logo')))
            ->favicon(asset(settings('logo')))
            ->brandLogoHeight('4rem')
            ->maxContentWidth(MaxWidth::Full)
            ->databaseNotifications()
            ->profile(isSimple: false)
            // ->colors([
            //     'primary' => Color::hex('#115cff'),
            // ])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([
                    NavigationItem::make('Dashboard')
                        ->icon('heroicon-o-home')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                        ->url(fn (): string => Dashboard::getUrl()),
                    // ...RoleResource::getNavigationItems(),
                    // ...UserResource::getNavigationItems(),
                    ...CustomerResource::getNavigationItems(),
                    ...SongResource::getNavigationItems(),
                    ...VideoSongResource::getNavigationItems(),
                    ...RemoveCopyrightRequestResource::getNavigationItems(),
                    // ...ArtistChannelResource::getNavigationItems(),
                    ...Setting::getNavigationItems(),
                    ...LabelResource::getNavigationItems(),
                    ...AnalyticsResource::getNavigationItems(),
                    ...BankAccountResource::getNavigationItems()
                ]);
            })
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
