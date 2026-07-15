@props(['title' => 'Dashboard', 'heading' => 'Dashboard', 'description' => ''])
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
        <aside class="hidden border-r border-slate-800 bg-slate-900/70 p-5 lg:flex lg:flex-col">
            <a href="{{ auth()->user()->getDashboardUrl() }}" class="flex items-center gap-3 font-bold text-white">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-blue-400 to-indigo-600">R</span> Resume AI
            </a>
            <p class="mt-3 text-xs font-semibold uppercase tracking-[.18em] text-slate-500">{{ auth()->user()->isRecruiter() ? 'Recruiter workspace' : 'Candidate workspace' }}</p>
            <nav class="mt-8 space-y-1">
                @if (auth()->user()->isJobSeeker())
                    <a href="{{ route('dashboard.job-seeker.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard.job-seeker.index') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">Overview</a>
                    <a href="{{ route('resumes.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('resumes.*') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">My resumes</a>
                    <a href="{{ route('dashboard.job-seeker.analyze') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard.job-seeker.analyze') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">Analyze a role</a>
                @else
                    <a href="{{ route('dashboard.recruiter.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard.recruiter.index') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">Overview</a>
                    <a href="{{ route('dashboard.recruiter.bulk-upload') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard.recruiter.bulk-upload') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">Bulk upload</a>
                    <a href="{{ route('dashboard.recruiter.candidates') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard.recruiter.candidates') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">Candidates</a>
                @endif
            </nav>
            <div class="mt-auto border-t border-slate-800 pt-4">
                <p class="truncate px-3 text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                <p class="truncate px-3 text-xs text-slate-500">{{ auth()->user()->email }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">@csrf <button class="w-full rounded-lg px-3 py-2 text-left text-sm text-slate-400 hover:bg-slate-800 hover:text-white">Sign out</button></form>
            </div>
        </aside>
        <main class="min-w-0">
            <header class="flex h-16 items-center justify-between border-b border-slate-800 bg-slate-900/50 px-5 lg:px-10">
                <a href="{{ auth()->user()->getDashboardUrl() }}" class="font-bold text-white lg:hidden">Resume AI</a>
                <div class="ml-auto flex items-center gap-3">
                    <span class="hidden text-sm text-slate-400 sm:block">{{ auth()->user()->name }}</span>
                    <span class="grid h-9 w-9 place-items-center rounded-full bg-blue-500/20 text-sm font-semibold text-blue-300">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </div>
            </header>
            <div class="mx-auto max-w-7xl px-5 py-8 lg:px-10">
                <div class="mb-8">
                    <p class="text-sm font-semibold uppercase tracking-[.18em] text-blue-400">{{ auth()->user()->isRecruiter() ? 'Recruiter mode' : 'Job seeker mode' }}</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-white">{{ $heading }}</h1>
                    @if ($description)<p class="mt-2 max-w-2xl text-sm leading-6 text-slate-400">{{ $description }}</p>@endif
                </div>
                {{ $slot }}
            </div>
        </main>
    </div>
    @livewireScripts
</body>
</html>
