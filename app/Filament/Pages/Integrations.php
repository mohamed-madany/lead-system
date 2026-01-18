<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Str;

class Integrations extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationLabel = 'الربط والاتصال';

    protected static ?string $title = 'إعدادات التكامل والربط الخارجي';

    protected static ?string $slug = 'integrations';

    protected string $view = 'filament.pages.integrations';

    public ?array $data = [];

    public function mount(): void
    {
        $tenant = Filament::getTenant();

        if (! $tenant->facebook_webhook_verify_token) {
            $tenant->update([
                'facebook_webhook_verify_token' => Str::random(40),
            ]);
        }

        $this->form->fill([
            'webhook_url' => url('/api/webhooks/'.$tenant->id),
            'verify_token' => $tenant->facebook_webhook_verify_token,
            'facebook_page_id' => $tenant->facebook_page_id,
            'facebook_access_token' => $tenant->facebook_access_token,
            'n8n_webhook_url' => $tenant->n8n_webhook_url,
            'ai_classification_enabled' => (bool)$tenant->ai_classification_enabled,
            'telegram_bot_token' => $tenant->telegram_bot_token,
            'telegram_chat_id' => $tenant->telegram_chat_id,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Integrations')
                    ->tabs([
                        Tab::make('Facebook')
                            ->label('📘 فيسبوك')
                            ->components([
                                Section::make('الخطوة 1: تهيئة الـ Webhook')
                                    ->description('انسخ الروابط التالية وضعها في Meta Developers')
                                    ->components([
                                        TextInput::make('webhook_url')
                                            ->label('رابط الـ Callback URL')
                                            ->readOnly()
                                            ->suffixAction(Action::make('copyUrl')->icon('heroicon-m-clipboard')->action(fn () => null)),
                                        TextInput::make('verify_token')
                                            ->label('رمز التحقق (Verify Token)')
                                            ->readOnly()
                                            ->suffixAction(Action::make('copyToken')->icon('heroicon-m-clipboard')->action(fn () => null)),
                                    ])->columns(2),

                                Section::make('الخطوة 2: بيانات الوصول')
                                    ->components([
                                        TextInput::make('facebook_page_id')
                                            ->label('معرف الصفحة (Page ID)')
                                            ->placeholder('أدخل الـ ID هنا...')
                                            ->required()
                                            ->extraInputAttributes(['style' => 'text-align: right; direction: ltr;']),
                                        TextInput::make('facebook_access_token')
                                            ->label('رمز الوصول (Token)')
                                            ->placeholder('الصق الـ Token هنا...')
                                            ->password()
                                            ->required()
                                            ->extraInputAttributes(['style' => 'text-align: right; direction: ltr;']),
                                    ])->columns(2),
                            ]),

                        Tab::make('n8n')
                            ->label('⚙️ n8n Integration')
                            ->components([
                                Section::make('ربط الأتمتة الخارجية')
                                    ->description('إرسال بيانات العملاء الجدد إلى n8n أو أي خدمة Webhook أخرى')
                                    ->components([
                                        TextInput::make('n8n_webhook_url')
                                            ->label('Webhook URL')
                                            ->placeholder('https://your-n8n-instance.com/webhook/...')
                                            ->url()
                                            ->extraInputAttributes(['style' => 'text-align: right; direction: ltr;']),
                                    ]),
                            ]),

                        Tab::make('AI')
                            ->label('🤖 تصنيف بالذكاء الاصطناعي')
                            ->components([
                                Section::make('الذكاء الاصطناعي')
                                    ->description('تفعيل ميزة تصنيف العملاء تلقائياً وتحليل جودتهم بناءً على البيانات المرسلة')
                                    ->components([
                                        Toggle::make('ai_classification_enabled')
                                            ->label('تفعيل التصنيف التلقائي')
                                            ->helperText('عند تفعيل هذا الخيار، سيقوم النظام بتحليل كل عميل جديد وتحديد "درجة الجودة" له تلقائياً.'),
                                    ]),
                            ]),

                        Tab::make('Telegram')
                            ->label('📲 إشعارات تليجرام')
                            ->components([
                                Section::make('تنبيهات لحظية')
                                    ->description('استقبل تنبيه فوري على تليجرام عند وصول كل عميل جديد')
                                    ->components([
                                        TextInput::make('telegram_bot_token')
                                            ->label('Bot Token')
                                            ->placeholder('123456789:ABCDefG...')
                                            ->password()
                                            ->extraInputAttributes(['style' => 'text-align: right; direction: ltr;']),
                                        TextInput::make('telegram_chat_id')
                                            ->label('Chat ID')
                                            ->placeholder('123456789')
                                            ->extraInputAttributes(['style' => 'text-align: right; direction: ltr;']),
                                    ])->columns(2),
                            ]),
                    ])->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $tenant = Filament::getTenant();
        $state = $this->form->getState();

        $tenant->update([
            'facebook_page_id' => $state['facebook_page_id'],
            'facebook_access_token' => $state['facebook_access_token'],
            'n8n_webhook_url' => $state['n8n_webhook_url'],
            'ai_classification_enabled' => $state['ai_classification_enabled'],
            'telegram_bot_token' => $state['telegram_bot_token'],
            'telegram_chat_id' => $state['telegram_chat_id'],
        ]);

        Notification::make()
            ->title('تم التحديث بنجاح')
            ->body('تم حفظ كافة إعدادات الربط بنجاح.')
            ->success()
            ->send();
    }
}
