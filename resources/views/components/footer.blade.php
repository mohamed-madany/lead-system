<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <!-- Company Info -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Leadsfiy Logo" class="h-8 w-8 rounded-lg object-cover">
                    <span class="mr-3 text-xl font-black text-white tracking-tighter uppercase">LEADSFIY</span>
                </div>
                <p class="text-gray-400 mb-4 leading-relaxed">
                    نظام ليدزفاي (Leadsfiy) هو الحل الأذكى لإدارة العملاء المحتملين وتتبع الصفقات. نساعدك على تحويل كل
                    فرصة تجارية إلى نجاح حقيقي من خلال أدوات أتمتة متقدمة.
                </p>
                <div class="flex space-x-reverse space-x-4">
                    <!-- Social Icons -->
                    <a href="#" class="text-gray-400 hover:text-primary-500 transition">
                        <x-filament::icon icon="heroicon-m-globe-alt" class="h-6 w-6" />
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-semibold mb-4">روابط سريعة</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="hover:text-primary-500 transition">الرئيسية</a></li>
                    <li><a href="{{ route('home') }}#features" class="hover:text-primary-500 transition">المميزات</a>
                    </li>
                    <li><a href="{{ route('home') }}#pricing" class="hover:text-primary-500 transition">الأسعار</a></li>
                </ul>
            </div>

            <!-- Legal & Support -->
            <div>
                <h3 class="text-white font-semibold mb-4">معلومات قانونية</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-primary-500 transition">سياسة الخصوصية</a></li>
                    <li><a href="#" class="hover:text-primary-500 transition">شروط الاستخدام</a></li>
                    <li><a href="{{ route('filament.admin.auth.login') }}"
                            class="hover:text-primary-500 transition">لوحة التحكم</a></li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 mt-8 pt-8 text-center">
            <p class="text-gray-500 text-sm">
                © {{ date('Y') }} Leadsfiy. جميع الحقوق محفوظة.
            </p>
            <p class="text-gray-600 text-xs mt-2 font-bold tracking-widest uppercase">
                Created by Mohamed Madany
            </p>
        </div>
    </div>
</footer>
