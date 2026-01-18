<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('super-admin')
            ->darkMode(false)
            ->userMenuItems([
                'dashboard' => \Filament\Navigation\MenuItem::make()
                    ->label('العودة للوحة الشركة')
                    ->url('/admin')
                    ->icon('heroicon-o-building-office-2'),
            ])
            ->colors([
                'primary' => '#005694', // Deep Professional Blue
                'gray' => Color::Slate,
            ])
            ->font('Cairo')
            ->brandName('نظام إدارة العملاء - الإدارة العليا')
            ->discoverResources(in: app_path('Filament/SuperAdmin/Resources'), for: 'App\\Filament\\SuperAdmin\\Resources')
            ->discoverPages(in: app_path('Filament/SuperAdmin/Pages'), for: 'App\\Filament\\SuperAdmin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/SuperAdmin/Widgets'), for: 'App\\Filament\\SuperAdmin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ])
            ->renderHook('panels::styles.after', fn () => new \Illuminate\Support\HtmlString('
                <style>
                    :root {
                        --primary-500: #005694;
                        --primary-600: #004576;
                    }
                    /* Global RTL Fixes */
                    html[dir="rtl"] body {
                        text-align: right;
                    }
                    html[dir="rtl"] .fi-section-header-heading,
                    html[dir="rtl"] .fi-section-header-description {
                        text-align: right !important;
                    }
                     /* Improved Sidebar */
                    .fi-sidebar {
                        background-color: #f8fafc !important;
                        border-inline-end: 1px solid rgba(0,0,0,0.08) !important;
                    }
                     .fi-sidebar-item-active {
                        background-color: rgba(0, 86, 148, 0.08) !important;
                        border-radius: 0.75rem !important;
                    }
                    /* Typography */
                    .fi-header-heading {
                        color: #1e293b !important;
                        font-weight: 800 !important;
                    }
                </style>
            '));
    }
}
