<div class="w-full">
    @if ($showSuccess)
        <!-- Success Message -->
        <div class="bg-green-50 border-2 border-green-500 rounded-2xl p-8 text-center animate-fade-in-up">
            <div class="mb-4">
                <svg class="h-16 w-16 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">شكراً لك! تم إرسال طلبك بنجاح</h3>
            <p class="text-gray-600 mb-4">
                سيتواصل معك فريقنا قريباً
            </p>
            @if ($leadTrackingId)
                <div class="bg-white rounded-lg p-4 inline-block">
                    <p class="text-sm text-gray-600 mb-1">رقم التتبع الخاص بك:</p>
                    <p class="text-xl font-bold text-primary-600">{{ $leadTrackingId }}</p>
                </div>
            @endif
            <div class="mt-6">
                <button wire:click="$set('showSuccess', false)"
                    class="text-primary-600 hover:text-primary-700 font-medium">
                    ← العودة للصفحة الرئيسية
                </button>
            </div>
        </div>
    @else
        <!-- Lead Capture Form -->
        <form wire:submit.prevent="submit" class="space-y-6">

            <!-- Honeypot (hidden field for spam protection) -->
            <input type="text" name="website" wire:model="website" style="display: none;" tabindex="-1"
                autocomplete="off">

            <!-- Rate Limit Error -->
            @error('rate_limit')
                <div class="bg-red-50 border-r-4 border-red-500 p-4 rounded-lg">
                    <p class="text-red-700">{{ $message }}</p>
                </div>
            @enderror

            @error('submission')
                <div class="bg-red-50 border-r-4 border-red-500 p-4 rounded-lg">
                    <p class="text-red-700">{{ $message }}</p>
                </div>
            @enderror

            <!-- Name Field (Required) -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    الاسم الكامل <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" wire:model.live="name"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('name') border-red-500 @enderror"
                    placeholder="أحمد محمد" autofocus autocomplete="name">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Email Field (Required) -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        البريد الإلكتروني <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" wire:model.live="email"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('email') border-red-500 @enderror"
                        placeholder="ahmed@company.com" autocomplete="email" dir="ltr">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Field (Required) -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        رقم الهاتف <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="phone" wire:model.live="phone"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('phone') border-red-500 @enderror"
                        placeholder="+966 50 123 4567" autocomplete="tel" dir="ltr">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Company Name (Optional) -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                        اسم الشركة
                    </label>
                    <input type="text" id="company_name" wire:model="company_name"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        placeholder="شركة التقنية المتقدمة" autocomplete="organization">
                </div>

                <!-- Job Title (Optional) -->
                <div>
                    <label for="job_title" class="block text-sm font-medium text-gray-700 mb-2">
                        المسمى الوظيفي
                    </label>
                    <input type="text" id="job_title" wire:model="job_title"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        placeholder="مدير تقني" autocomplete="organization-title">
                </div>
            </div>

            <!-- Source Field (Required) -->
            <div>
                <label for="source" class="block text-sm font-medium text-gray-700 mb-2">
                    كيف سمعت عنا؟ <span class="text-red-500">*</span>
                </label>
                <select id="source" wire:model="source"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition @error('source') border-red-500 @enderror">
                    <option value="">اختر إجابة...</option>
                    @foreach (\App\Domain\Lead\Enums\LeadSource::cases() as $source)
                        @if (!in_array($source->value, ['api', 'import', 'manual', 'form']))
                            <option value="{{ $source->value }}">{{ $source->label() }}</option>
                        @endif
                    @endforeach
                    <option value="form">بحث جوجل / موقع إلكتروني</option>
                </select>
                @error('source')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes/Message (Optional) -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    رسالتك
                </label>
                <textarea id="notes" wire:model="notes" rows="4"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition resize-none @error('notes') border-red-500 @enderror"
                    placeholder="أخبرنا كيف يمكننا مساعدتك..." maxlength="2000"></textarea>
                <div class="flex justify-between mt-1">
                    @error('notes')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @else
                        <p class="text-sm text-gray-500">اختياري</p>
                    @enderror
                    <p class="text-sm text-gray-500">{{ strlen($notes) }}/2000</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white px-8 py-4 rounded-lg font-bold text-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center gap-3"
                    @if ($isSubmitting) disabled @endif>
                    <span wire:loading.remove>إرسال الطلب</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        جاري الإرسال...
                    </span>
                </button>
            </div>

            <!-- Privacy Note -->
            <p class="text-xs text-gray-500 text-center">
                بإرسال هذا النموذج، أنت توافق على
                <a href="#" class="text-primary-600 hover:underline">سياسة الخصوصية</a>
                و
                <a href="#" class="text-primary-600 hover:underline">شروط الاستخدام</a>
            </p>
        </form>
    @endif
</div>
