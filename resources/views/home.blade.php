<x-layouts.app title="نظام إدارة العملاء المحتملين - الصفحة الرئيسية"
    description="نظام احترافي لإدارة العملاء المحتملين وتتبع الفرص التجارية بذكاء">

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-primary-50 via-white to-primary-50 py-20 md:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="text-center md:text-right animate-fade-in-up">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        احصل على <span class="text-primary-600">عملاء محتملين</span> أكثر جودة
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        نظام ذكي لإدارة العملاء المحتملين يساعدك على تحويل الزوار إلى عملاء فعليين من خلال التتبع الذكي
                        والتقييم التلقائي
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="{{ route('contact') }}"
                            class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-4 rounded-lg font-bold text-lg shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1">
                            ابدأ مجاناً الآن
                        </a>
                        <a href="#features"
                            class="bg-white hover:bg-gray-50 text-primary-600 px-8 py-4 rounded-lg font-bold text-lg border-2 border-primary-600 transition">
                            اكتشف المزيد
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="mt-12 flex items-center justify-center md:justify-start gap-6 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>مجاني بالكامل</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>سهل الاستخدام</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>دعم عربي</span>
                        </div>
                    </div>
                </div>

                <!-- Hero Image/Illustration -->
                <div class="hidden md:block">
                    <div class="relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-primary-400 to-primary-600 rounded-3xl transform rotate-6 opacity-20">
                        </div>
                        <div class="relative bg-white rounded-3xl shadow-2xl p-8 border-4 border-primary-100">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-10 w-10 bg-primary-100 rounded-full flex items-center justify-center">
                                            <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">عميل جديد</div>
                                            <div class="text-sm text-gray-500">منذ دقيقتين</div>
                                        </div>
                                    </div>
                                    <div class="bg-green-500 h-3 w-3 rounded-full animate-pulse"></div>
                                </div>
                                <div class="flex items-center gap-3 bg-primary-50 p-4 rounded-lg">
                                    <div class="flex-1">
                                        <div class="flex justify-between mb-2">
                                            <span class="text-sm font-medium">نسبة التحويل</span>
                                            <span class="text-sm font-bold text-primary-600">81%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-primary-600 h-2 rounded-full" style="width: 81%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="bg-blue-50 p-3 rounded-lg text-center">
                                        <div class="text-2xl font-bold text-blue-600">10</div>
                                        <div class="text-xs text-gray-600">عملاء جدد</div>
                                    </div>
                                    <div class="bg-green-50 p-3 rounded-lg text-center">
                                        <div class="text-2xl font-bold text-green-600">3</div>
                                        <div class="text-xs text-gray-600">مؤهلين</div>
                                    </div>
                                    <div class="bg-yellow-50 p-3 rounded-lg text-center">
                                        <div class="text-2xl font-bold text-yellow-600">1</div>
                                        <div class="text-xs text-gray-600">تم الإغلاق</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    لماذا تختار نظامنا؟
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    أدوات احترافية تساعدك على إدارة عملائك المحتملين بكفاءة عالية
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="bg-gradient-to-br from-primary-50 to-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-primary-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">تقييم تلقائي ذكي</h3>
                    <p class="text-gray-600 leading-relaxed">
                        نظام تقييم ذكي يحلل جودة العملاء المحتملين تلقائياً بناءً على معايير متعددة ويعطي كل عميل درجة
                        من 100
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="bg-gradient-to-br from-green-50 to-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-green-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">تحليلات متقدمة</h3>
                    <p class="text-gray-600 leading-relaxed">
                        احصل على رؤى واضحة عن أداء عملائك المحتملين مع تقارير تفصيلية ولوحة تحكم شاملة
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="bg-gradient-to-br from-purple-50 to-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="bg-purple-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">تكامل سلس</h3>
                    <p class="text-gray-600 leading-relaxed">
                        اتصال مباشر مع N8n و Webhooks لأتمتة عمليات المتابعة وإرسال الإشعارات الفورية
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-primary-600 to-primary-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                جاهز لبدء إدارة عملائك بذكاء؟
            </h2>
            <p class="text-xl text-primary-100 mb-8">
                ابدأ الآن واحصل على أول 100 عميل محتمل مجاناً
            </p>
            <a href="{{ route('contact') }}"
                class="inline-block bg-white text-primary-600 px-10 py-4 rounded-lg font-bold text-lg shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-105">
                ابدأ الآن →
            </a>
        </div>
    </section>

</x-layouts.app>
