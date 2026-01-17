<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Contracts\Support\Htmlable;

class Register extends BaseRegister
{
    public function getHeading(): string | Htmlable
    {
        return 'ابدأ رحلتك معنا';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return 'امتلك نظاماً قوياً لإدارة مبيعاتك في دقائق';
    }

    public function getView(): string
    {
        return 'filament.auth.register';
    }
}
