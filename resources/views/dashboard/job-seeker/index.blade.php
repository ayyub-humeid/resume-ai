<x-layouts.dashboard-layout title="Dashboard" heading="Good to see you, {{ $user->name }}"
    description="Keep your resumes organized and prepare for the roles you want.">
    <div class="grid gap-4 sm:grid-cols-3">
        <!-- Card: Total Resumes -->
        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm font-medium">Total Resumes</p>
                    <p class="mt-2 text-3xl font-bold text-white">{{ $resumeCount ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card: Total Analyses -->
        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm font-medium">Analyses Performed</p>
                    <p class="mt-2 text-3xl font-bold text-white">{{ $analysisCount ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card: Avg Score -->
        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-sm font-medium">Average Score</p>
                    <p class="mt-2 text-3xl font-bold text-white">{{ $averageScore ? $averageScore . '%' : '—' }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <h2 class="mb-4 text-lg font-semibold text-white">Start here</h2>
        <div class="grid gap-4 md:grid-cols-2">
            <!-- Upload Resume Button -->
            <a href="{{ route('dashboard.job-seeker.resumes.index') }}"
                class="group rounded-2xl border border-blue-400/20 bg-gradient-to-br from-blue-500/20 to-indigo-500/10 p-6 transition hover:border-blue-400/50">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-lg font-bold mb-2">Manage Resumes</h4>
                        <p class="text-blue-100 text-sm">Add a new resume for analysis</p>
                    </div>
                    <svg class="w-8 h-8 opacity-50 group-hover:opacity-100 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </a>

            <!-- Analyze Resume Button -->
            <a href="{{ route('dashboard.job-seeker.analyze') }}"
                class="group rounded-2xl border border-indigo-400/20 bg-gradient-to-br from-indigo-500/20 to-violet-500/10 p-6 transition hover:border-indigo-400/50">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-lg font-bold mb-2">Analyze Resume</h4>
                        <p class="text-purple-100 text-sm">Get AI-powered insights</p>
                    </div>
                    <svg class="w-8 h-8 opacity-50 group-hover:opacity-100 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Analyses -->
    <div class="mt-8 rounded-2xl border border-slate-800 bg-slate-900/60 p-6">
        <h2 class="text-lg font-semibold text-white">Your next step</h2>
        <div class="py-8">
            <p class="text-sm text-slate-400">Upload a resume, then paste a job description to receive a focused
                match
                analysis.</p>
        </div>
    </div>
</x-layouts.dashboard-layout>
