<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    public function getHeading(): string | Htmlable
    {
        return 'مرحباً بك مجدداً';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return 'سجل دخولك لإدارة عملائك بذكاء';
    }

    public function getView(): string
    {
        return 'filament.auth.login';
    }
}
