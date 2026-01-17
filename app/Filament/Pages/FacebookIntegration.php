<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FacebookIntegration extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-share';

    protected static ?string $navigationLabel = 'ربط فيسبوك';

    protected static ?string $title = 'إعدادات ربط Facebook Lead Ads';

    protected static ?string $slug = 'facebook-integration';

    protected string $view = 'filament.pages.facebook-integration';

    public ?array $data = [];

    public function mount(): void
    {
        $tenant = Filament::getTenant();

        if (! $tenant->facebook_webhook_verify_token) {
            $tenant->update([
                'facebook_webhook_verify_token' => Str::random(40),
            ]);
        }

        // ملء كافة الحقول بالبيانات لضمان ظهورها
        $this->form->fill([
            'webhook_url' => url('/api/webhooks/'.$tenant->id),
            'verify_token' => $tenant->facebook_webhook_verify_token,
            'facebook_page_id' => $tenant->facebook_page_id,
            'facebook_access_token' => $tenant->facebook_access_token,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('الخطوة 1: تهيئة الـ Webhook في فيسبوك')
                    ->description('هذه الروابط "للقراءة فقط"، قم بنسخها ووضعها في إعدادات Meta Developers')
                    ->components([
                        TextInput::make('webhook_url')
                            ->label('رابط الـ Callback URL')
                            ->readOnly()
                            ->extraAttributes([
                                'class' => 'bg-gray-100 dark:bg-gray-800 border-dashed cursor-not-allowed font-mono text-xs',
                                'onclick' => "this.select(); document.execCommand('copy');",
                            ])
                            ->helperText('اضغط على الحقل للنسخ السريع')
                            ->suffixAction(
                                Action::make('copyUrl')
                                    ->icon('heroicon-m-clipboard')
                                    ->action(fn () => null)
                            ),

                        TextInput::make('verify_token')
                            ->label('رمز التحقق (Verify Token)')
                            ->readOnly()
                            ->extraAttributes([
                                'class' => 'bg-gray-100 dark:bg-gray-800 border-dashed cursor-not-allowed font-mono text-xs',
                                'onclick' => "this.select(); document.execCommand('copy');",
                            ])
                            ->helperText('اضغط على الحقل للنسخ السريع')
                            ->suffixAction(
                                Action::make('copyToken')
                                    ->icon('heroicon-m-clipboard')
                                    ->action(fn () => null)
                            ),
                    ])->columns(2),

                Section::make('الخطوة 2: بيانات الوصول النهائية')
                    ->description('أدخل البيانات التالية التي حصلت عليها من صفحتك في فيسبوك')
                    ->components([
                        TextInput::make('facebook_page_id')
                            ->label('معرف الصفحة (Page ID)')
                            ->placeholder('أدخل الـ ID هنا...')
                            ->required()
                            ->extraInputAttributes(['style' => 'text-align: right; direction: ltr;'])
                            ->helperText('يمكنك الكتابة واللصق هنا'),

                        TextInput::make('facebook_access_token')
                            ->label('رمز الوصول (Page Access Token)')
                            ->placeholder('الصق الـ Token هنا...')
                            ->password()
                            ->required()
                            ->extraInputAttributes(['style' => 'text-align: right; direction: ltr;'])
                            ->helperText('تأكد من لصق الـ Token كاملاً'),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $tenant = Filament::getTenant();
        $this->form->getState();

        $tenant->update([
            'facebook_page_id' => $this->data['facebook_page_id'],
            'facebook_access_token' => $this->data['facebook_access_token'],
        ]);

        Notification::make()
            ->title('تم التحديث بنجاح')
            ->body('نظامك الآن جاهز لاستقبال العملاء من فيسبوك.')
            ->success()
            ->send();
    }
}
