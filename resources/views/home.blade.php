<x-layouts.app title="نظام إدارة العملاء - نظم عملائك وزود مبيعاتك"
    description="نظام احترافي لإدارة تتبع العملاء المحتملين (Leads) ورفع كفاءة فريق المبيعات من خلال الأتمتة والتقارير الذكية">

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-primary-50 via-white to-primary-50 py-20 md:py-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="text-center md:text-right animate-fade-in-up order-2 md:order-1">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6 ">
                        تحكم في كل <span class="text-primary-600">عميل مهتم</span>.. من اللحظة الأولى وحتى إتمام البيع
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        حوّل الفوضى إلى نظام متكامل. اجمع بيانات عملائك من فيسبوك، واتساب، وموقعك الإلكتروني في مكان
                        واحد، وقم بتوجيه فريق مبيعاتك للرد عليهم فوراً وباحترافية.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="/admin/register"
                            class="bg-primary-600 hover:bg-primary-700 text-white px-10 py-4 rounded-xl font-bold text-lg shadow-xl shadow-primary-500/20 transition transform hover:-translate-y-1">
                            ابدأ تنظيم مبيعاتك الآن
                        </a>
                        <a href="#pricing"
                            class="bg-white hover:bg-gray-50 text-gray-900 px-10 py-4 rounded-xl font-bold text-lg border-2 border-gray-100 transition shadow-sm">
                            عرض الباقات والأسعار
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div
                        class="mt-12 flex flex-wrap items-center justify-center md:justify-start gap-x-8 gap-y-4 text-sm font-medium text-gray-500">
                        <div class="flex items-center gap-2">
                            <span class="bg-green-100 text-green-700 p-1 rounded-full"><x-filament::icon
                                    icon="heroicon-m-check" class="w-3 h-3" /></span>
                            <span>أتمتة كاملة للبيانات</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="bg-green-100 text-green-700 p-1 rounded-full"><x-filament::icon
                                    icon="heroicon-m-check" class="w-3 h-3" /></span>
                            <span>لا فاقد في البيانات</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="bg-green-100 text-green-700 p-1 rounded-full"><x-filament::icon
                                    icon="heroicon-m-check" class="w-3 h-3" /></span>
                            <span>تقارير أداء فورية</span>
                        </div>
                    </div>
                </div>

                <!-- Hero Illustration -->
                <div class="order-1 md:order-2">
                    <div class="relative">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-primary-400 to-primary-600 rounded-[2.5rem] blur opacity-20">
                        </div>
                        <div class="relative bg-white rounded-[2.5rem] shadow-2xl p-8 border border-gray-100">
                            <div class="space-y-6">
                                <div
                                    class="flex items-center justify-between bg-gray-50 p-5 rounded-2xl border border-gray-100 shadow-sm">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-12 w-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                            <x-filament::icon icon="heroicon-m-user-plus"
                                                class="w-6 h-6 text-primary-600" />
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">أحمد محمد - عقارات</div>
                                            <div
                                                class="text-xs text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded-full inline-block mt-1">
                                                عميل مهتم جداً</div>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 font-medium">الآن</div>
                                </div>

                                <div class="bg-primary-50 p-6 rounded-2xl border border-primary-100">
                                    <div class="flex justify-between mb-3 items-center">
                                        <span class="font-bold text-gray-900">سرعة استجابة الفريق</span>
                                        <span class="text-lg font-black text-primary-600">92%</span>
                                    </div>
                                    <div class="w-full bg-gray-200/50 rounded-full h-3">
                                        <div class="bg-primary-600 h-3 rounded-full shadow-sm shadow-primary-500/50"
                                            style="width: 92%"></div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-blue-50/50 p-4 rounded-2xl text-center border border-blue-100">
                                        <div class="text-3xl font-black text-blue-600 mb-1">124</div>
                                        <div class="text-xs font-bold text-blue-700 uppercase tracking-wider">إجمالي
                                            المهتمين</div>
                                    </div>
                                    <div class="bg-emerald-50/50 p-4 rounded-2xl text-center border border-emerald-100">
                                        <div class="text-3xl font-black text-emerald-600 mb-1">18</div>
                                        <div class="text-xs font-bold text-emerald-700 uppercase tracking-wider">صفقات
                                            مغلقة</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Problem & Solution Section -->
    <section id="features" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <span class="text-primary-600 font-bold tracking-widest uppercase text-sm mb-4 block">لماذا تحتاج
                    إلينا؟</span>
                <h2 class="text-3xl md:text-5xl font-black text-gray-900 mb-6">
                    وداعاً لضياع بيانات العملاء في "واتساب" أو "الإكسيل"
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    نحن لا نبحث لك عن عملاء، بل نحافظ على كل عميل قمت بجلبه بمجهودك. نضمن لك ألا يفوتك طلب واحد وأن يتم
                    الرد على الجميع في أسرع وقت.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-10 text-right" dir="rtl">
                <!-- Feature 1 -->
                <div
                    class="group p-8 rounded-3xl border border-gray-100 hover:border-primary-100 hover:shadow-2xl hover:shadow-primary-500/10 transition duration-500 bg-white">
                    <div
                        class="bg-primary-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-primary-500/30 group-hover:scale-110 transition duration-500">
                        <x-filament::icon icon="heroicon-o-squares-plus" class="h-8 w-8 text-white" />
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">تجميع تلقائي ذكي</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        اربط إعلانات فيسبوك، انستجرام، ونماذج موقعك مباشرة بالسيستم. كل عميل يرسل بياناته سيظهر فوراً
                        أمام فريقك بكل تفاصيله.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="group p-8 rounded-3xl border border-gray-100 hover:border-emerald-100 hover:shadow-2xl hover:shadow-emerald-500/10 transition duration-500 bg-white">
                    <div
                        class="bg-emerald-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition duration-500">
                        <x-filament::icon icon="heroicon-o-bolt" class="h-8 w-8 text-white" />
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">تصنيف فوري للجودة</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        تعرف على العميل "الساخن" (المستعد للشراء) من العميل "البارد" تلقائياً. وفر وقت فريقك للتركيز على
                        الصفقات التي تحقق أرباحاً حقيقية.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="group p-8 rounded-3xl border border-gray-100 hover:border-orange-100 hover:shadow-2xl hover:shadow-orange-500/10 transition duration-500 bg-white">
                    <div
                        class="bg-orange-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-orange-500/30 group-hover:scale-110 transition duration-500">
                        <x-filament::icon icon="heroicon-o-presentation-chart-line" class="h-8 w-8 text-white" />
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">تقارير أداء ومتابعة</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        هل يرد موظفوك بسرعة؟ ما هو أفضل مصدر لعملائك؟ لوحة بيانات واضحة تعطيك إجابات فورية تساعدك على
                        اتخاذ قرارات تسويقية ذكية.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Industry Solutions -->
    <section class="py-24 bg-gray-50/50 text-right overflow-hidden relative" dir="rtl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-3xl md:text-4xl font-black text-center mb-16 text-gray-900">حلول تناسب طموح مشروعك</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-lg transition group">
                    <div class="text-primary-600 font-black text-xl mb-4 flex items-center gap-3">
                        <span class="w-2 h-8 bg-primary-600 rounded-full group-hover:h-12 transition-all"></span>
                        المراكز الطبية
                    </div>
                    <p class="text-gray-600 leading-relaxed font-medium">تنظيم مواعيد الحجز القادمة من فيسبوك فوراً،
                        وتقليل فاقد المواعيد من خلال المتابعة الذكية لكل حجز.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-lg transition group">
                    <div class="text-primary-600 font-black text-xl mb-4 flex items-center gap-3">
                        <span class="w-2 h-8 bg-primary-600 rounded-full group-hover:h-12 transition-all"></span>
                        الشركات العقارية
                    </div>
                    <p class="text-gray-600 leading-relaxed font-medium">تتبع اهتمام العملاء بالمشروعات المختلفة
                        وتوزيعهم على الوسطاء بدقة لضمان أعلى نسبة إغلاق مبيعات.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-lg transition group">
                    <div class="text-primary-600 font-black text-xl mb-4 flex items-center gap-3">
                        <span class="w-2 h-8 bg-primary-600 rounded-full group-hover:h-12 transition-all"></span>
                        مراكز التدريب
                    </div>
                    <p class="text-gray-600 leading-relaxed font-medium">إدارة المسجلين في الكورسات وربطهم بعمليات الدفع
                        والمتابعة، مع أتمتة إرسال تفاصيل المحاضرات والـ Location.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-lg transition group">
                    <div class="text-primary-600 font-black text-xl mb-4 flex items-center gap-3">
                        <span class="w-2 h-8 bg-primary-600 rounded-full group-hover:h-12 transition-all"></span>
                        شركات الخدمات
                    </div>
                    <p class="text-gray-600 leading-relaxed font-medium">سواء كنت تقدم خدمات صيانة أو ديكور، System
                        Lead يضمن لك تنظيم الطلبات والرد على استفسارات الأسعار بسرعة.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-20">
                <span class="text-primary-600 font-bold tracking-widest uppercase text-sm mb-4 block">الأسعار</span>
                <h2 class="text-3xl md:text-5xl font-black text-gray-900 mb-6">استثمار ذكي لنمو مستدام</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    باقات شفافة تناسب حجم فريقك وطموح شركتك. اختر الباقة التي تبدأ بها رحلة نجاحك اليوم.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-10 text-right" dir="rtl">
                <!-- Starter -->
                <div
                    class="bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-2xl transition border border-gray-100 flex flex-col group">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">باقة البداية</h3>
                    <div class="mb-8">
                        <div class="text-5xl font-black text-gray-900 mb-2">1,500 <span
                                class="text-xl font-bold text-gray-500">ج.م</span></div>
                        <div class="text-gray-500 font-bold">تدفع شهرياً</div>
                    </div>
                    <ul class="space-y-4 mb-10 text-gray-600 flex-1 font-medium italic">
                        <li class="flex items-center gap-3"><x-filament::icon icon="heroicon-m-check-circle"
                                class="w-5 h-5 text-green-500" /> إدارة حتى 150 عميل / شهر</li>
                        <li class="flex items-center gap-3"><x-filament::icon icon="heroicon-m-check-circle"
                                class="w-5 h-5 text-green-500" /> موظف مبيعات واحد</li>
                        <li class="flex items-center gap-3"><x-filament::icon icon="heroicon-m-check-circle"
                                class="w-5 h-5 text-green-500" /> ربط فيسبوك وواتساب</li>
                    </ul>
                    <a href="/admin/register"
                        class="block text-center bg-gray-50 group-hover:bg-primary-600 group-hover:text-white text-gray-900 font-bold py-4 rounded-2xl transition duration-300">ابدأ
                        الآن مجاناً</a>
                </div>

                <!-- Growth (Featured) -->
                <div
                    class="bg-white p-10 rounded-[2.5rem] shadow-2xl ring-4 ring-primary-600 relative transform md:-translate-y-6 flex flex-col group">
                    <span
                        class="absolute -top-5 left-1/2 -translate-x-1/2 bg-primary-600 text-white text-sm font-black px-6 py-2 rounded-full uppercase tracking-tighter">الأكثر
                        مبيعاً</span>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">باقة النمو</h3>
                    <div class="mb-8">
                        <div class="text-5xl font-black text-primary-600 mb-2">3,000 <span
                                class="text-xl font-bold text-primary-400">ج.م</span></div>
                        <div class="text-gray-500 font-bold">تدفع شهرياً</div>
                    </div>
                    <ul class="space-y-4 mb-10 text-gray-800 flex-1 font-bold">
                        <li class="flex items-center gap-3"><x-filament::icon icon="heroicon-m-check-circle"
                                class="w-5 h-5 text-primary-600" /> إدارة حتى 750 عميل / شهر</li>
                        <li class="flex items-center gap-3"><x-filament::icon icon="heroicon-m-check-circle"
                                class="w-5 h-5 text-primary-600" /> 5 موظفين مبيعات</li>
                        <li class="flex items-center gap-3"><x-filament::icon icon="heroicon-m-check-circle"
                                class="w-5 h-5 text-primary-600" /> نظام التقييم والفلترة الذكي</li>
                        <li class="flex items-center gap-3"><x-filament::icon icon="heroicon-m-check-circle"
                                class="w-5 h-5 text-primary-600" /> تقارير أداء تفصيلية</li>
                    </ul>
                    <a href="/admin/register"
                        class="block text-center bg-primary-600 hover:bg-primary-700 text-white font-bold py-5 rounded-2xl transition shadow-xl shadow-primary-500/40">اشترك
                        في النمو</a>
                </div>

                <!-- Professional -->
                <div
                    class="bg-gradient-to-br from-gray-900 to-gray-800 p-10 rounded-[2.5rem] shadow-sm hover:shadow-2xl transition border border-gray-800 flex flex-col text-white group">
                    <h3 class="text-2xl font-bold text-white mb-6">الباقة الاحترافية</h3>
                    <div class="mb-8">
                        <div class="text-5xl font-black text-white mb-2">6,000 <span
                                class="text-xl font-bold text-gray-400">ج.م</span></div>
                        <div class="text-gray-400 font-bold">تدفع شهرياً</div>
                    </div>
                    <ul class="space-y-4 mb-10 text-gray-300 flex-1 font-medium">
                        <li class="flex items-center gap-3"><x-filament::icon icon="heroicon-m-sparkles"
                                class="w-5 h-5 text-yellow-400" /> عملاء مهتمين غير محدودين</li>
                        <li class="flex items-center gap-3"><x-filament::icon icon="heroicon-m-sparkles"
                                class="w-5 h-5 text-yellow-400" /> فريق غير محدود</li>
                        <li class="flex items-center gap-3"><x-filament::icon icon="heroicon-m-sparkles"
                                class="w-5 h-5 text-yellow-400" /> دعم فني VIP مخصص</li>
                        <li class="flex items-center gap-3"><x-filament::icon icon="heroicon-m-sparkles"
                                class="w-5 h-5 text-yellow-400" /> ربط API وتطوير مخصص</li>
                    </ul>
                    <a href="{{ route('contact') }}"
                        class="block text-center bg-white text-gray-900 font-bold py-4 rounded-2xl transition hover:bg-gray-100">تواصل
                        للشركات الكبرى</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-24 bg-primary-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
            <h2 class="text-4xl md:text-6xl font-black mb-8 leading-tight">جاهز لزيادة مبيعاتك بنسبة 40%؟</h2>
            <p class="text-2xl text-primary-100 mb-12 font-medium">
                انضم لأكثر من 100 مشروع يديرون مبيعاتهم بذكاء من خلال منصتنا. ابدأ تجربتك المجانية اليوم.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="/admin/register"
                    class="bg-white text-primary-600 px-12 py-5 rounded-2xl font-black text-xl shadow-2xl hover:bg-gray-50 transition transform hover:-translate-y-1">
                    جرب المنصة مجاناً الآن
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
