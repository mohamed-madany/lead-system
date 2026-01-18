<x-filament-panels::page>
    <div class="space-y-6 rtl-container" dir="rtl">
        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-6 flex justify-start">
                <x-filament::button type="submit" size="xl" class="px-12 shadow-xl shadow-primary-500/30 font-bold">
                    حفظ كافة الإعدادات
                </x-filament::button>
            </div>
        </form>

        <div
            class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12 bg-gray-50/50 dark:bg-gray-900/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-800">
            <div class="md:col-span-2">
                <x-filament::section icon="heroicon-o-information-circle" icon-color="primary">
                    <x-slot name="heading">
                        <span class="font-bold text-gray-900 dark:text-white">نصيحة تقنية</span>
                    </x-slot>

                    <div class="prose dark:prose-invert max-w-none text-sm leading-relaxed text-right">
                        <p>تفعيل كافة خيارات الربط يساعدك على بناء "نظام مبيعات آلي" بالكامل.
                            يمكنك البدء بـ <b>ربط فيسبوك</b> أولاً، ثم تفعيل <b>إشعارات تليجرام</b> لتكون أول من يعلم
                            عند وصول عميل جديد.</p>
                        <p class="mt-4">إذا كنت تستخدم أدوات مثل <b>n8n</b> أو <b>Make</b>، يمكنك استخدام خيار الـ
                            Webhook لإرسال البيانات إلى جداول جوجل أو أي نظام خارجي آخر.</p>
                    </div>
                </x-filament::section>
            </div>

            <div class="space-y-6">
                <div
                    class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-6 text-white shadow-2xl overflow-hidden relative group">
                    <div class="relative z-10 text-right">
                        <h3 class="text-xl font-bold mb-3">دعم الإعدادات</h3>
                        <p class="text-sm text-primary-50/90 mb-6 leading-relaxed">هل تواجه صعوبة في الحصول على Tokens؟
                            تواصل معنا وسيقوم خبير تقني بمساعدتك مجاناً.</p>
                        <a href="https://wa.me/your-number" target="_blank"
                            class="inline-flex items-center gap-3 px-6 py-3 bg-white text-primary-700 hover:bg-primary-50 rounded-xl text-sm font-bold transition-all transform hover:-translate-y-1 active:scale-95 shadow-lg">
                            <x-filament::icon icon="heroicon-m-chat-bubble-left-right" class="w-5 h-5" />
                            فتح تذكرة دعم
                        </a>
                    </div>
                    <div
                        class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-colors">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .rtl-container {
            text-align: right !important;
        }

        .fi-section {
            border-radius: 1.25rem !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
        }

        .fi-tabs {
            border-radius: 1.25rem !important;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            background: white;
            padding: 0.5rem;
        }

        .dark .fi-tabs {
            background: rgba(15, 23, 42, 0.6);
            border-color: rgba(255, 255, 255, 0.05);
        }

        /* Input text alignment for English tokens in RTL */
        input {
            text-align: left !important;
            direction: ltr !important;
        }

        input::placeholder {
            text-align: right !important;
            direction: rtl !important;
        }

        .fi-tabs-item {
            border-radius: 0.75rem !important;
            font-weight: 600 !important;
        }
    </style>
</x-filament-panels::page>
