<aside id="dashboard-sidebar" class="fixed inset-y-0 z-50 flex w-64 flex-col bg-slate-950 p-5 transition-transform duration-300 ease-in-out lg:sticky lg:top-0 lg:h-screen lg:flex lg:translate-x-0 lg:overflow-y-auto lg:border-r lg:border-slate-800 lg:bg-slate-900/70
    {{ app()->getLocale() == 'ar' ? 'right-0 translate-x-full border-l border-slate-800 lg:border-l-0' : 'left-0 -translate-x-full border-r border-slate-800 lg:border-r-0' }}">
    <div class="flex items-center justify-between">
        <a href="{{ auth()->user()->getDashboardUrl() }}" class="flex items-center gap-3 font-bold text-white">
            <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-blue-400 to-indigo-600">R</span>
            Resume AI
        </a>
        <button onclick="toggleMobileSidebar()" class="text-slate-400 hover:text-white lg:hidden focus:outline-none" aria-label="{{ __('Close Menu') }}">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    <p class="mt-3 text-xs font-semibold uppercase tracking-[.18em] text-slate-500">
        {{ auth()->user()->isRecruiter() ? __('Recruiter workspace') : __('Candidate workspace') }}</p>
    <nav class="mt-8 space-y-1">
        @if (auth()->user()->isJobSeeker())
            <a href="{{ route('dashboard.job-seeker.index') }}"
                class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard.job-seeker.index') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">{{ __('Overview') }}</a>
            <a href="{{ route('dashboard.job-seeker.resumes.index') }}"
                class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard.job-seeker.resumes.*') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">{{ __('My resumes') }}</a>
            <a href="{{ route('dashboard.job-seeker.analyze') }}"
                class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard.job-seeker.analyze') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">{{ __('Manage & Analyze a role') }}</a>
        @else
            <a href="{{ route('dashboard.recruiter.index') }}"
                class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard.recruiter.index') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">{{ __('Overview') }}</a>
            <a href="{{ route('dashboard.recruiter.jobs') }}"
                class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard.recruiter.jobs') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">{{ __('Jobs') }}</a>
            <a href="{{ route('dashboard.recruiter.bulk-upload') }}"
                class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard.recruiter.bulk-upload') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">{{ __('Bulk upload') }}</a>
            <a href="{{ route('dashboard.recruiter.candidates') }}"
                class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard.recruiter.candidates') ? 'bg-blue-500/15 text-blue-300' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">{{ __('Candidates') }}</a>
        @endif
    </nav>
    <div class="mt-auto border-t border-slate-800 pt-4">
        <p class="truncate px-3 text-sm font-medium text-white">{{ auth()->user()->name }}</p>
        <p class="truncate px-3 text-xs text-slate-500">{{ auth()->user()->email }}</p>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">@csrf <button
                class="w-full rounded-lg px-3 py-2 text-start text-sm text-slate-400 hover:bg-slate-800 hover:text-white">{{ __('Sign out') }}</button></form>
    </div>
</aside>
