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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->darkMode(false)
            ->login(\App\Filament\Pages\Auth\Login::class)
            ->registration(\App\Filament\Pages\Auth\Register::class) // تفعيل صفحة التسجيل للمستخدمين
            ->tenant(\App\Models\Tenant::class, slugAttribute: 'slug') // تفعيل نظام الـ Multi-tenancy
            ->tenantRegistration(\App\Filament\Pages\Tenancy\RegisterTenant::class)
            ->userMenuItems([
                'super_admin' => \Filament\Navigation\MenuItem::make()
                    ->label('لوحة الإدارة العليا')
                    ->url('/super-admin')
                    ->icon('heroicon-o-shield-check')
                    ->visible(fn (): bool => auth()->user()?->is_platform_admin ?? false),
            ])
            ->colors([
                'primary' => '#005694', // Deep Professional Blue
                'secondary' => '#FF9505',
                'gray' => Color::Slate,
            ])
            ->font('Cairo')
            ->brandName('Leadsfiy')
            ->brandLogo(asset('assets/logo.jpg'))
            ->brandLogoHeight('3rem')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets removed for clean dashboard
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
                    /* Soften Borders & Shadows */
                    .fi-section {
                        border-radius: 1rem !important;
                        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
                    }
                    /* Header Typography */
                    h1, h2, h3, h4, .fi-header-heading {
                        color: #1e293b !important;
                        font-weight: 800 !important;
                    }
                </style>
            '));
    }
}
