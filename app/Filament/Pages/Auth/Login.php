<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Schemas\Schema;

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

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent()
                    ->label('البريد الإلكتروني')
                    ->placeholder('example@mail.com'),
                $this->getPasswordFormComponent()
                    ->label('كلمة المرور')
                    ->placeholder('••••••••'),
                $this->getRememberFormComponent()
                    ->label('تذكرني'),
            ]);
    }
}
