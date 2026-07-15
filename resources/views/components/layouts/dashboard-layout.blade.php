@props([
    'title' => 'Dashboard',
    'heading' => 'Dashboard',
    'description' => '',
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} · Resume AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-slate-950 text-slate-200 antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        <x-layouts.sidebar-component />
        <main class="min-w-0">
            <header
                class="flex h-16 items-center justify-between border-b border-slate-800 bg-slate-900/50 px-5 lg:px-10">
                <a href="{{ auth()->user()->getDashboardUrl() }}" class="font-bold text-white lg:hidden">Resume AI</a>
                <div class="ml-auto flex items-center gap-3">
                    <span class="hidden text-sm text-slate-400 sm:block">{{ auth()->user()->name }}</span>
                    <span
                        class="grid h-9 w-9 place-items-center rounded-full bg-blue-500/20 text-sm font-semibold text-blue-300">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </div>
            </header>
            <div class="mx-auto max-w-7xl px-5 py-8 lg:px-10">
                <div class="mb-8  flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[.18em] text-blue-400">
                            {{ auth()->user()->isRecruiter() ? 'Recruiter mode' : 'Job seeker mode' }}</p>
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
    @livewireScripts
</body>

</html>
