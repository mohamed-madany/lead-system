<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    <svg class="h-10 w-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span class="mr-3 text-xl font-bold text-gray-900">نظام إدارة العملاء</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-reverse space-x-8">
                <a href="{{ route('home') }}"
                    class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition">
                    الرئيسية
                </a>
                <a href="{{ route('home') }}#features"
                    class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition">
                    المميزات
                </a>
                <a href="{{ route('contact') }}"
                    class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition">
                    اتصل بنا
                </a>
                <a href="{{ route('filament.admin.auth.login') }}"
                    class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition">
                    تسجيل الدخول
                </a>
            </div>

            <!-- CTA Button -->
            <div class="hidden md:block">
                <a href="{{ route('contact') }}"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-lg font-medium transition duration-200 shadow-lg hover:shadow-xl">
                    ابدأ الآن
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button"
                    class="text-gray-700 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-md p-2"
                    id="mobile-menu-button">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t">
            <a href="{{ route('home') }}"
                class="block text-gray-700 hover:bg-gray-100 hover:text-primary-600 px-3 py-2 rounded-md text-base font-medium">
                الرئيسية
            </a>
            <a href="{{ route('home') }}#features"
                class="block text-gray-700 hover:bg-gray-100 hover:text-primary-600 px-3 py-2 rounded-md text-base font-medium">
                المميزات
            </a>
            <a href="{{ route('contact') }}"
                class="block text-gray-700 hover:bg-gray-100 hover:text-primary-600 px-3 py-2 rounded-md text-base font-medium">
                اتصل بنا
            </a>
            <a href="{{ route('filament.admin.auth.login') }}"
                class="block text-gray-700 hover:bg-gray-100 hover:text-primary-600 px-3 py-2 rounded-md text-base font-medium">
                تسجيل الدخول
            </a>
            <a href="{{ route('contact') }}"
                class="block bg-primary-600 text-white px-3 py-2 rounded-md text-base font-medium text-center mt-2">
                ابدأ الآن
            </a>
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
@endpush
