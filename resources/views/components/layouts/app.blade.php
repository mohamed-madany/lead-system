<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $title ?? 'نظام إدارة العملاء المحتملين - Lead Management System' }}</title>
    <meta name="description" content="{{ $description ?? 'نظام احترافي لإدارة العملاء المحتملين وتتبع الفرص التجارية' }}">
    <meta name="keywords" content="إدارة العملاء المحتملين, CRM, تتبع المبيعات, نظام إدارة علاقات العملاء">
    <meta name="author" content="Lead Management System">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="{{ $title ?? 'نظام إدارة العملاء المحتملين' }}">
    <meta property="og:description" content="{{ $description ?? 'نظام احترافي لإدارة العملاء المحتملين' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Lead Management System">

    <!-- Tailwind CSS CDN for now - will compile later -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#e0f2ff',
                            100: '#c2e1ff',
                            200: '#85c6ff',
                            300: '#47abff',
                            400: '#0a90ff',
                            500: '#016fb9',
                            600: '#015995',
                            700: '#014371',
                            800: '#002d4d',
                            900: '#001729',
                        },
                        secondary: {
                            50: '#fff7e6',
                            100: '#ffefcc',
                            200: '#ffd799',
                            300: '#ffbf66',
                            400: '#ffa733',
                            500: '#ff9505',
                            600: '#cc7704',
                            700: '#995903',
                            800: '#663b02',
                            900: '#331d01',
                        },
                        success: {
                            500: '#22c55e',
                            600: '#16a34a',
                        },
                        warning: {
                            500: '#ff9505',
                        },
                        danger: {
                            500: '#ef4444',
                        }
                    },
                    fontFamily: {
                        'arabic': ['Cairo', 'Segoe UI', 'Tahoma', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Google Fonts - Cairo for Arabic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', 'Segoe UI', Tahoma, sans-serif;
        }

        /* RTL Support */
        [dir="rtl"] .ltr\:text-left {
            text-align: right;
        }

        /* Custom Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>

    @livewireStyles
    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-900 antialiased">

    <!-- Navigation -->
    @include('components.navigation')

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer -->
    @include('components.footer')

    @livewireScripts
    @stack('scripts')
</body>

</html>
