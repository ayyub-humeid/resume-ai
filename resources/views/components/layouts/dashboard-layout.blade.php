@props([
    'title' => 'Dashboard',
    'heading' => 'Dashboard',
    'description' => '',
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} · Resume AI</title>
    <script>
        const USER_ID = {{ Auth::id() ?? 'null' }};
    </script>
    @vite(['resources/js/app.js'])
    @vite(['resources/css/app.css'])
    @livewireStyles
    <!-- Material Symbols for icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="min-h-screen bg-slate-950 text-slate-200 antialiased {{ app()->getLocale() === 'ar' ? 'font-arabic' : '' }}">
   
    <div id="sidebar-backdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm hidden lg:hidden"></div>

    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        <x-layouts.sidebar-component />
        <main class="min-w-0">
            <header
                class="flex h-16 items-center justify-between border-b border-slate-800 bg-slate-900/50 px-5 lg:px-10">
                <div class="flex items-center gap-3">
                    <button onclick="toggleMobileSidebar()" class="text-slate-400 hover:text-white lg:hidden focus:outline-none flex items-center justify-center" aria-label="{{ __('Open Menu') }}">
                        <span class="material-symbols-outlined text-[24px]">menu</span>
                    </button>
                    <a href="{{ auth()->user()->getDashboardUrl() }}" class="font-bold text-white lg:hidden">Resume AI</a>
                </div>
                <div class="ml-auto flex items-center gap-4">
                    <div class="mx-2">
                        <x-general-components.language-switcher />
                    </div>
                    <div class="m-x-2">
                        <livewire:general.notification-bell />
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="hidden text-sm text-slate-400 sm:block">{{ auth()->user()->name }}</span>
                        <span class="grid h-9 w-9 place-items-center rounded-full bg-blue-500/20 text-sm font-semibold text-blue-300">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                </div>
            </header>
            <div class="mx-auto max-w-7xl px-5 py-8 lg:px-10">
                <div class="mb-8  flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[.18em] text-blue-400">
                            {{ auth()->user()->isRecruiter() ? __('Recruiter mode') : __('Job seeker mode') }}</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-white">{{ $heading }}</h1>
                        @if ($description)
                            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-400">{{ $description }}</p>
                        @endif
                    </div>

                </div>
                {{ $slot }}
            </div>
        </main>
    </div>
     <!-- Modern Tailwind Confirmation Modal -->
    <x-general-components.toast />
    <x-general-components.confirmation-modal />
    @livewireScripts

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('dashboard-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const isRtl = document.documentElement.dir === 'rtl';

            if (sidebar.classList.contains('translate-x-0')) {
                // Close
                sidebar.classList.remove('translate-x-0');
                if (isRtl) {
                    sidebar.classList.add('translate-x-full');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
                backdrop.classList.add('hidden');
            } else {
                // Open
                if (isRtl) {
                    sidebar.classList.remove('translate-x-full');
                } else {
                    sidebar.classList.remove('-translate-x-full');
                }
                sidebar.classList.add('translate-x-0');
                backdrop.classList.remove('hidden');
            }
        }
    </script>
</body>

</html>
