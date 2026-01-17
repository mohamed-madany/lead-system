<x-layouts.app title="اتصل بنا - نظام إدارة العملاء المحتملين"
    description="تواصل معنا الآن وابدأ في إدارة عملائك المحتملين بكفاءة">

    <div class="bg-gradient-to-br from-primary-50 via-white to-primary-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    تواصل معنا
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    املأ النموذج أدناه وسنتواصل معك في أقرب وقت ممكن
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-start">

                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-10">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            أرسل لنا رسالة
                        </h2>
                        <p class="text-gray-600">
                            سنرد عليك خلال 24 ساعة
                        </p>
                    </div>

                    @livewire('lead-capture-form')
                </div>

                <!-- Contact Information -->
                <div class="space-y-8">

                    <!-- Why Contact Us -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">
                            لماذا تتواصل معنا؟
                        </h3>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 text-green-500 flex-shrink-0 mt-1" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-900">استشارة مجانية</p>
                                    <p class="text-gray-600 text-sm">احصل على استشارة مجانية حول كيفية تحسين عملية إدارة
                                        العملاء المحتملين</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 text-green-500 flex-shrink-0 mt-1" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-900">تجربة مجانية</p>
                                    <p class="text-gray-600 text-sm">ابدأ باستخدام النظام فوراً مع أول 100 عميل محتمل
                                        مجاناً</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 text-green-500 flex-shrink-0 mt-1" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-900">دعم فني مجاني</p>
                                    <p class="text-gray-600 text-sm">فريق دعم فني متاح لمساعدتك في أي وقت</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Details -->
                    <div class="bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl shadow-lg p-8 text-white">
                        <h3 class="text-xl font-bold mb-6">
                            معلومات التواصل
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>info@leadsystem.com</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span dir="ltr">+966 50 123 4567</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>الأحد - الخميس: 9:00 صباحاً - 5:00 مساءً</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                            <div class="text-3xl font-bold text-primary-600 mb-1">24/7</div>
                            <div class="text-sm text-gray-600">دعم فني متواصل</div>
                        </div>
                        <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                            <div class="text-3xl font-bold text-primary-600 mb-1">&lt; 2س</div>
                            <div class="text-sm text-gray-600">وقت الاستجابة</div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

</x-layouts.app>
