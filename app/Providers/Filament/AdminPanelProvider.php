<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Enums\Width;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->darkMode(false)
            ->colors([
                // 'primary' => Color::Orange,
                'primary' => [
                    '50' => '#FFF7ED',
                    '100' => '#FFEDD5',
                    '200' => '#FED7AA',
                    '300' => '#FDBA74',
                    '400' => '#FB923C',
                    '500' => '#F97316',
                    '600' => '#EA580C',
                    '700' => '#C2410C',
                    '800' => '#9A3412',
                    '900' => '#7C2D12',
                ]
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
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
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->maxContentWidth(Width::Full) // Contenedor al ancho completo
            // ->topNavigation() //Navegación arriba (topbar)
            ->brandName('SNTE | Sección 56') // Nombre de la marca
            ->brandLogo(asset('images/logosnte56@4x-8.png')) // Logo personalizado
            ->brandLogoHeight('6rem') // Altura del logo
            ->favicon(asset('images/snte56.png'))
            ->renderHook('panels::head.end', fn () => '
                    <style>
                        .fi-logo {
                            padding: 0.75rem 0;
                        }
                    </style>
                ')            
            ->profile()
            ->sidebarCollapsibleOnDesktop()
            ->sidebarFullyCollapsibleOnDesktop()
            ->collapsedSidebarWidth('4rem')            
            ;
    }
}
