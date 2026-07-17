@props(['pageTitle' => 'Resume AI', 'pageDescription' => 'Resume Ai', 'pageHeading' => ''])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Dynamic Page Title -->
    <title>{{ $pageTitle }} - Intelligent Resume Analyzer</title>

    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Stylesheets & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Custom CSS Base Enhancements -->
    <style>
        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Cairo', sans-serif" : "'Plus Jakarta Sans', sans-serif" }};
            background-color: #080C14;
            color: #E2E8F0;
        }

        /* Custom scrollbar to keep it sleek */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #0B0F19;
        }

        ::-webkit-scrollbar-thumb {
            background: #1E293B;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }
    </style>

</head>

<body class="min-h-full flex flex-col antialiased bg-[#080C14] text-slate-200 {{ app()->getLocale() === 'ar' ? 'font-arabic' : '' }}">

    <!-- Ambient glowing backgrounds to feel premium, custom-designed, not standard template -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <!-- Main top radial accent -->
        <div class="absolute -top-[30%] -left-[10%] w-[70%] h-[70%] rounded-full bg-blue-600/5 blur-[120px]"></div>
        <!-- Right side accent -->
        <div class="absolute top-[20%] -right-[15%] w-[50%] h-[50%] rounded-full bg-indigo-600/5 blur-[100px]"></div>
        <!-- Bottom left accent -->
        <div class="absolute -bottom-[20%] -left-[10%] w-[60%] h-[60%] rounded-full bg-slate-900/10 blur-[80px]"></div>
    </div>

    <!-- Navigation Bar -->
    <x-general-components.navbar />

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- Page Header -->
        @if ($pageHeading)
            <div class="relative mb-10 pb-6 border-b border-slate-800/60">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="space-y-1">
                        <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">{{ $pageHeading }}</h2>
                        @if ($pageDescription)
                            <p class="text-sm font-medium text-slate-400 max-w-3xl">{{ $pageDescription }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Content Slot (child components inject here) -->
        <div class="w-full">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <script src="{{ asset('js/engamentFunctions.js') }}"></script>
    <x-general-components.footer />

    @livewireScripts
</body>

</html>