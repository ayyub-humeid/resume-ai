@props(['title' => 'Resume AI'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} · Resume AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-950 font-sans text-slate-200 antialiased {{ app()->getLocale() === 'ar' ? 'font-arabic' : '' }}">
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-48 -top-40 h-[34rem] w-[34rem] rounded-full bg-blue-600/15 blur-[130px]"></div>
        <div class="absolute -right-48 top-72 h-[30rem] w-[30rem] rounded-full bg-indigo-600/10 blur-[130px]"></div>
    </div>
    <header class="sticky top-0 z-40 border-b border-white/5 bg-slate-950/80 backdrop-blur-xl">
        <div class="mx-auto flex h-18 max-w-7xl items-center justify-between px-5 sm:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3 font-bold text-white">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-blue-400 to-indigo-600 shadow-lg shadow-blue-950/60">R</span>
                Resume AI
            </a>
            <div class="flex items-center gap-3">
                <x-general-components.language-switcher />
                @auth
                    <a href="{{ auth()->user()->getDashboardUrl() }}" class="hidden text-sm font-medium text-slate-300 hover:text-white sm:block">{{ __('Hi, :name', ['name' => auth()->user()->name]) }}</a>
                    <a href="{{ auth()->user()->getDashboardUrl() }}" class="rounded-lg bg-blue-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-400">{{ __('Open dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-semibold text-slate-300 transition hover:text-white">{{ __('Sign in') }}</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-blue-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-400">{{ __('Get started') }}</a>
                @endauth
            </div>
        </div>
    </header>
    {{ $slot }}
    <footer class="border-t border-white/5 py-8 text-center text-sm text-slate-500">© {{ date('Y') }} Resume AI. {{ __('Better matches, clearer decisions.') }}</footer>
    @livewireScripts
</body>
</html>
