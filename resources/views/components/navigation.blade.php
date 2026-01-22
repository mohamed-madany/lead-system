<nav class="bg-[#020617]/80 backdrop-blur-md border-b border-white/5 sticky top-0 z-50 py-3">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center" dir="rtl">
        <!-- Logo -->
        <div class="flex items-center gap-10">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Leadsfiy Logo" class="w-10 h-10 rounded-lg object-cover">
                <span class="text-xl font-black text-white tracking-tighter uppercase">LEADSFIY</span>
            </a>

            <!-- Desktop Links -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}#features"
                    class="text-slate-300 hover:text-primary-400 transition text-sm font-bold">المميزات</a>
                <a href="{{ route('home') }}#pricing"
                    class="text-slate-300 hover:text-primary-400 transition text-sm font-bold">الأسعار</a>
                <a href="{{ route('contact') }}"
                    class="text-slate-300 hover:text-primary-400 transition text-sm font-bold">اتصل بنا</a>
            </div>
        </div>

        <!-- Auth & Mobile Button -->
        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('filament.admin.auth.login') }}"
                    class="text-slate-300 hover:text-white font-bold text-sm transition">تسجيل دخول</a>
                <a href="/admin/register"
                    class="bg-primary-600 hover:bg-primary-700 text-white font-black text-sm px-6 py-2.5 rounded-lg transition-all active:scale-95 shadow-sm">ابدأ
                    مجاناً</a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="text-slate-300 hover:text-white p-2" id="mobile-menu-button">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div class="md:hidden hidden bg-[#020617] border-t border-white/5" id="mobile-menu">
        <div class="px-6 py-4 space-y-4" dir="rtl">
            <a href="{{ route('home') }}#features" class="block text-slate-300 font-bold">المميزات</a>
            <a href="{{ route('home') }}#pricing" class="block text-slate-300 font-bold">الأسعار</a>
            <a href="{{ route('contact') }}" class="block text-slate-300 font-bold">اتصل بنا</a>
            <hr class="border-white/5">
            <a href="{{ route('filament.admin.auth.login') }}" class="block text-slate-300 font-bold">تسجيل دخول</a>
            <a href="/admin/register"
                class="block bg-primary-600 text-white font-black text-center py-3 rounded-lg">ابدأ مجاناً</a>
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
@endpush
