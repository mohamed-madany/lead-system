<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Schemas\Schema;

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

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent()
                    ->label('الاسم الكامل')
                    ->placeholder('أدخل اسمك بالكامل'),
                $this->getEmailFormComponent()
                    ->label('البريد الإلكتروني')
                    ->placeholder('example@mail.com'),
                $this->getPasswordFormComponent()
                    ->label('كلمة المرور')
                    ->placeholder('••••••••'),
                $this->getPasswordConfirmationFormComponent()
                    ->label('تأكيد كلمة المرور')
                    ->placeholder('••••••••'),
            ]);
    }
}
