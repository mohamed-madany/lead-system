<x-layouts.app title="Leadsfiy - حول مبيعاتك لآلة أوتوماتيكية"
    description="Leadsfiy هو النظام الأذكى لإدارة وتتبع العملاء المحتملين، مصمم لمساعدة شركات الوطن العربي على النمو أسرع من أي وقت مضى.">

    <!-- Styles for Enhanced Animations & UX -->
    @push('styles')
        <style>
            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px) rotate(0deg);
                }

                50% {
                    transform: translateY(-20px) rotate(1deg);
                }
            }

            .float-animation {
                animation: float 6s ease-in-out infinite;
            }

            .glass-panel {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }

            .hero-gradient-text {
                background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 50%, #2563eb 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .text-glow {
                text-shadow: 0 0 30px rgba(59, 130, 246, 0.5);
            }

            html {
                scroll-behavior: smooth;
            }

            ::selection {
                background: #3b82f6;
                color: white;
            }
        </style>
    @endpush

    <!-- Modern Navigation -->
    <nav class="fixed top-0 w-full z-50 glass-panel border-b border-white/5 py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center" dir="rtl">
            <div class="flex items-center gap-12">
                <a href="/" class="text-2xl font-black text-white tracking-tighter">
                    LEAD<span class="text-primary-500 italic uppercase">SFIY</span>
                </a>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features"
                        class="text-slate-400 hover:text-white transition text-sm font-bold">المميزات</a>
                    <a href="#how-it-works" class="text-slate-400 hover:text-white transition text-sm font-bold">كيف
                        يعمل</a>
                    <a href="#pricing" class="text-slate-400 hover:text-white transition text-sm font-bold">الأسعار</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="/admin/login" class="text-white font-bold text-sm px-6 py-2">تسجيل دخول</a>
                <a href="/admin/register"
                    class="bg-primary-600 hover:bg-primary-500 text-white font-black text-sm px-6 py-3 rounded-xl transition shadow-lg shadow-primary-500/20">ابدأ
                    مجاناً</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center bg-[#020617] overflow-hidden pt-20">
        <!-- Modern Grid Background -->
        <div
            class="absolute inset-0 z-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20">
        </div>
        <div class="absolute inset-0 z-0"
            style="background-image: radial-gradient(circle at 50% 50%, rgba(30, 58, 138, 0.1) 0%, transparent 70%);">
        </div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <!-- Content Side -->
                <div class="text-right animate-fade-in-up order-2 lg:order-1">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-sm font-bold mb-8">
                        <span class="flex h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                        المنصة رقم #1 للتوسع في المبيعات
                    </div>

                    <h1 class="text-6xl md:text-8xl font-black text-white leading-[1.05] mb-8 tracking-tight">
                        وداعاً لضياع <span class="hero-gradient-text text-glow">العملاء</span>
                    </h1>

                    <p class="text-2xl text-slate-400 mb-12 leading-relaxed font-medium max-w-2xl">
                        لا تسمح لبياناتك بالتبخر. <span class="text-white italic">Leadsfiy</span> ينظم، يتبع، ويغلق
                        الصفقات من أجلك. أتمتة كاملة تبدأ من لحظة تسجيل العميل.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-6 justify-start">
                        <a href="/admin/register"
                            class="group relative bg-white text-slate-950 px-12 py-6 rounded-[2rem] font-black text-2xl transition hover:scale-105 active:scale-95 flex items-center justify-center gap-4 shadow-2xl shadow-white/10">
                            احصل علي حساب مجاني
                            <x-filament::icon icon="heroicon-m-sparkles" class="w-6 h-6 text-primary-600" />
                        </a>
                        <a href="#features"
                            class="bg-slate-900/50 hover:bg-slate-900 text-white px-10 py-6 rounded-[2rem] font-bold text-xl border border-slate-800 transition backdrop-blur-md flex items-center justify-center">
                            شاهد كيف يعمل
                        </a>
                    </div>

                    <!-- Social Proof -->
                    <div class="mt-16 flex items-center gap-4">
                        <div class="flex -space-x-3 rtl:space-x-reverse">
                            <img class="w-12 h-12 rounded-full border-4 border-slate-950 shadow-xl"
                                src="https://i.pravatar.cc/150?u=1" alt="user">
                            <img class="w-12 h-12 rounded-full border-4 border-slate-950 shadow-xl"
                                src="https://i.pravatar.cc/150?u=2" alt="user">
                            <img class="w-12 h-12 rounded-full border-4 border-slate-950 shadow-xl"
                                src="https://i.pravatar.cc/150?u=3" alt="user">
                        </div>
                        <div class="text-slate-500 text-sm font-bold">نال ثقة +2,500 مدير مبيعات</div>
                    </div>
                </div>

                <!-- Visual Side -->
                <div class="order-1 lg:order-2 float-animation">
                    <div class="relative">
                        <!-- Abstract Shapes -->
                        <div class="absolute -top-20 -right-20 w-64 h-64 bg-primary-600/30 rounded-full blur-[100px]">
                        </div>
                        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-blue-500/20 rounded-full blur-[100px]">
                        </div>

                        <!-- Dashboard GUI -->
                        <div class="relative glass-panel rounded-[3rem] p-4 shadow-3xl overflow-hidden">
                            <div class="bg-white/5 p-4 flex items-center justify-between">
                                <span
                                    class="bg-green-500/20 text-green-400 text-[10px] font-black px-3 py-1 rounded-full uppercase">Live
                                    Feed</span>
                                <div class="flex gap-2">
                                    <div class="w-2 h-2 rounded-full bg-white/20"></div>
                                    <div class="w-2 h-2 rounded-full bg-white/20"></div>
                                </div>
                            </div>
                            <!-- Mock Data Rows -->
                            <div class="p-8 space-y-6">
                                <div
                                    class="flex items-center justify-between p-4 rounded-2xl bg-white/5 border border-white/5">
                                    <div class="flex items-center gap-4 text-right" dir="rtl">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-orange-500/20 flex items-center justify-center">
                                            <x-filament::icon icon="heroicon-m-fire" class="w-6 h-6 text-orange-500" />
                                        </div>
                                        <div>
                                            <div class="text-white font-bold">محمد علي (عقارات)</div>
                                            <div class="text-slate-500 text-xs">Hot Lead 🔥</div>
                                        </div>
                                    </div>
                                    <div class="text-primary-500 font-bold">$125k</div>
                                </div>
                                <div
                                    class="flex items-center justify-between p-4 rounded-2xl bg-white/5 border border-white/5">
                                    <div class="flex items-center gap-4 text-right" dir="rtl">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                                            <x-filament::icon icon="heroicon-m-paper-airplane"
                                                class="w-6 h-6 text-blue-500" />
                                        </div>
                                        <div>
                                            <div class="text-white font-bold">سارة أحمد (تدريب)</div>
                                            <div class="text-slate-500 text-xs">Waiting for follow-up</div>
                                        </div>
                                    </div>
                                    <div class="bg-blue-500/20 text-blue-400 text-xs px-3 py-1 rounded-full">New</div>
                                </div>
                                <!-- Progress -->
                                <div class="pt-4 border-t border-white/5">
                                    <div class="flex justify-between text-white text-xs mb-2">
                                        <span>Target: $1M</span>
                                        <span>Current: $840k</span>
                                    </div>
                                    <div class="h-2 bg-white/5 rounded-full overflow-hidden">
                                        <div class="h-full bg-primary-600 rounded-full" style="width: 84%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Innovative Features Section -->
    <section id="features" class="py-32 bg-[#020617]" dir="rtl">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tight italic">لماذا يختار المحترفون
                    Leadsfiy؟</h2>
                <div class="w-24 h-1 bg-primary-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="glass-panel p-10 rounded-[2.5rem] hover:transform hover:-translate-y-2 transition duration-500">
                    <div
                        class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mb-8 shadow-2xl shadow-blue-600/30">
                        <x-filament::icon icon="heroicon-o-cpu-chip" class="h-8 w-8 text-white" />
                    </div>
                    <h3 class="text-2xl font-black text-white mb-4">تصنيف ذكي (AI Scoring)</h3>
                    <p class="text-slate-400 leading-relaxed font-medium">نظامنا يقيم العملاء تلقائياً، يخبرك من هو
                        الجاد ومن يضيع وقتك، لتركز طاقتك دائماً على الأهم.</p>
                </div>
                <!-- Add more features similarly -->
                <div
                    class="glass-panel p-10 rounded-[2.5rem] hover:transform hover:-translate-y-2 transition duration-500 border-t-4 border-t-primary-600">
                    <div
                        class="w-16 h-16 bg-primary-600 rounded-2xl flex items-center justify-center mb-8 shadow-2xl shadow-primary-600/30">
                        <x-filament::icon icon="heroicon-o-link" class="h-8 w-8 text-white" />
                    </div>
                    <h3 class="text-2xl font-black text-white mb-4">ربط عميق (Deep Integration)</h3>
                    <p class="text-slate-400 leading-relaxed font-medium">اربط إعلانات فيسبوك، انستجرام، واتساب، ونماذج
                        موقعك في أقل من دقيقة. البيانات تصل في لحظتها.</p>
                </div>
                <div
                    class="glass-panel p-10 rounded-[2.5rem] hover:transform hover:-translate-y-2 transition duration-500">
                    <div
                        class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center mb-8 shadow-2xl shadow-emerald-600/30">
                        <x-filament::icon icon="heroicon-o-chart-bar" class="h-8 w-8 text-white" />
                    </div>
                    <h3 class="text-2xl font-black text-white mb-4">التحليلات التنبؤية</h3>
                    <p class="text-slate-400 leading-relaxed font-medium">لا نقدم أرقاماً فقط، بل نقدم رؤى مستقبلية.
                        اعرف مبيعاتك المتوقعة للشهر القادم بناءً على حجم البيانات الحالية.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern CTA -->
    <section class="py-32 bg-primary-600 relative overflow-hidden">
        <div class="absolute inset-0 bg-[#020617] opacity-10"></div>
        <div class="max-w-4xl mx-auto px-6 text-center text-white relative z-10">
            <h2 class="text-5xl md:text-7xl font-black mb-10 leading-tight">ابدأ رحلة السيطرة اليوم</h2>
            <p class="text-2xl text-primary-100 mb-12 font-medium opacity-80">
                انضم لمئات الشركات التي ضاعفت مبيعاتها باستخدام نظامنا. لا حدود لنموك.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="/admin/register"
                    class="bg-white text-slate-950 px-12 py-6 rounded-[2rem] font-black text-2xl shadow-3xl hover:bg-slate-50 transition">
                    ابدأ تجربتك المجانية
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
