<x-filament-panels::page>
    <div class="space-y-6 rtl-container" dir="rtl">
        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-6 flex justify-start">
                <x-filament::button type="submit" size="xl" class="px-12 shadow-xl shadow-primary-500/30 font-bold">
                    حفظ وإعداد الربط
                </x-filament::button>
            </div>
        </form>

        <div
            class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12 bg-gray-50/50 dark:bg-gray-900/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-800">
            <div class="md:col-span-2">
                <x-filament::section icon="heroicon-o-information-circle" icon-color="primary">
                    <x-slot name="heading">
                        <span class="font-bold text-gray-900 dark:text-white">دليل الإعداد السريع</span>
                    </x-slot>

                    <div class="prose dark:prose-invert max-w-none text-sm leading-relaxed text-right">
                        <div class="flex items-start gap-4 mb-5 group">
                            <span
                                class="flex-shrink-0 w-8 h-8 rounded-xl bg-primary-600 text-white flex items-center justify-center text-sm font-bold shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform">1</span>
                            <p class="m-0 pt-1">توجه إلى <a href="https://developers.facebook.com" target="_blank"
                                    class="font-bold text-primary-600 dark:text-primary-400 hover:underline">Meta for
                                    Developers</a> وأنشئ تطبيقاً من نوع <b>Business</b>.</p>
                        </div>
                        <div class="flex items-start gap-4 mb-5 group">
                            <span
                                class="flex-shrink-0 w-8 h-8 rounded-xl bg-primary-600 text-white flex items-center justify-center text-sm font-bold shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform">2</span>
                            <p class="m-0 pt-1">أضف منتج <b>Webhooks</b>، اختر <b>Page</b> من القائمة، ثم اضغط على
                                <b>Subscribe to this object</b>.</p>
                        </div>
                        <div class="flex items-start gap-4 mb-5 group">
                            <span
                                class="flex-shrink-0 w-8 h-8 rounded-xl bg-primary-600 text-white flex items-center justify-center text-sm font-bold shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform">3</span>
                            <p class="m-0 pt-1">انسخ <b>رابط الـ Callback</b> و <b>رمز التحقق</b> من الأعلى وضعهما في
                                فيسبوك، ثم اختر حدث <code>leadgen</code> واضغط <b>Save</b>.</p>
                        </div>
                        <div class="flex items-start gap-4 group">
                            <span
                                class="flex-shrink-0 w-8 h-8 rounded-xl bg-primary-600 text-white flex items-center justify-center text-sm font-bold shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform">4</span>
                            <p class="m-0 pt-1">أخيراً، أدخل <b>Page ID</b> والـ <b>Token</b> في نموذج "بيانات الوصول"
                                أعلاه واضغط حفظ لتبدأ في استقبال العملاء!</p>
                        </div>
                    </div>
                </x-filament::section>
            </div>

            <div class="space-y-6">
                <div
                    class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-6 text-white shadow-2xl overflow-hidden relative group">
                    <div class="relative z-10 text-right">
                        <h3 class="text-xl font-bold mb-3">هل تحتاج مساعدة؟</h3>
                        <p class="text-sm text-primary-50/90 mb-6 leading-relaxed">فريقنا جاهز لمساعدتك في عملية الربط
                            التقني عبر واتساب أو من خلال الدليل المصور.</p>
                        <a href="https://wa.me/your-number" target="_blank"
                            class="inline-flex items-center gap-3 px-6 py-3 bg-white text-primary-700 hover:bg-primary-50 rounded-xl text-sm font-bold transition-all transform hover:-translate-y-1 active:scale-95 shadow-lg">
                            <x-filament::icon icon="heroicon-m-chat-bubble-left-right" class="w-5 h-5" />
                            تحدث مع الدعم الفني
                        </a>
                    </div>
                    <!-- Decor element -->
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
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.05) !important;
        }

        .dark .fi-section {
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            background-color: rgba(30, 41, 59, 0.4) !important;
        }

        .fi-input-wrp {
            border-radius: 0.85rem !important;
            transition: all 0.2s ease;
        }

        .fi-input-wrp:focus-within {
            ring: 2px solid #016fb9 !important;
            border-color: #016fb9 !important;
        }

        /* Fix label alignment */
        .fi-fo-field-wrp-label {
            justify-content: flex-start !important;
            margin-bottom: 0.5rem !important;
        }

        html[dir="rtl"] .fi-fo-field-wrp-label {
            text-align: right !important;
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
    </style>
</x-filament-panels::page>
