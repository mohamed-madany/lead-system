<?php

namespace App\Providers\Filament;
use App\Filament\Pages\Tenancy\RegisterTenant;
use App\Models\Tenant;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Widgets\FilamentInfoWidget;
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
            ->colors([
                'primary' => '#016fb9',
                'secondary' => '#FF9505',
                'gray' => Color::Slate,
            ])
            ->font('Cairo')
            ->brandName('نظام إدارة العملاء')
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
                        --primary-500: #016fb9;
                        --primary-600: #015995;
                    }
                    /* Global RTL Fixes */
                    html[dir="rtl"] .fi-section-header-heading,
                    html[dir="rtl"] .fi-section-header-description {
                        text-align: right !important;
                    }
                    /* Form overlap fix */
                    .fi-fo-field-wrp {
                        margin-bottom: 1.5rem !important;
                    }
                    .fi-fo-component-ctn {
                        gap: 1.5rem !important;
                    }
                    /* Topbar Polish */
                    .fi-topbar {
                        background-color: rgba(255, 255, 255, 0.7) !important;
                        backdrop-filter: blur(12px) !important;
                        border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
                    }
                    .dark .fi-topbar {
                        background-color: rgba(15, 23, 42, 0.7) !important;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
                    }
                    /* Primary Button matching */
                    .fi-btn-primary, .fi-btn-primary:hover {
                        background-color: #016fb9 !important;
                        border-radius: 0.5rem !important;
                    }
                    /* Brand name color */
                    .fi-brand {
                        color: #016fb9 !important;
                        font-weight: 800 !important;
                        letter-spacing: -0.025em;
                    }
                    /* Sidebar polish */
                    .fi-sidebar {
                        background-color: #f8fafc !important;
                        border-inline-end: 1px solid rgba(0, 0, 0, 0.05) !important;
                    }
                    .dark .fi-sidebar {
                        background-color: #020617 !important;
                        border-inline-end: 1px solid rgba(255, 255, 255, 0.05) !important;
                    }
                    /* Sidebar Active Item */
                    .fi-sidebar-item-active {
                        background-color: rgba(1, 111, 185, 0.08) !important;
                        border-radius: 0.5rem !important;
                    }
                    .fi-sidebar-item-active .fi-sidebar-item-label,
                    .fi-sidebar-item-active .fi-sidebar-item-icon {
                        color: #016fb9 !important;
                    }
                    /* Forms & Inputs focus color */
                    input:focus, select:focus, textarea:focus {
                        border-color: #016fb9 !important;
                        --tw-ring-color: #016fb9 !important;
                    }
                </style>
            '));
    }
}
