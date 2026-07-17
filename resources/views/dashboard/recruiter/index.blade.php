<x-layouts.dashboard-layout title="{{ __('Recruiter dashboard') }}" heading="{{ __('Hiring workspace') }}"
    description="{{ __('Organize applicant files, evaluate job fit, and build a high-confidence shortlist.') }}">
    <livewire:recruiter.recruiter-dashboard />

    <div class="mt-8 grid gap-4 md:grid-cols-2">
        <a href="{{ route('dashboard.recruiter.bulk-upload') }}"
            class="rounded-2xl border border-blue-400/20 bg-gradient-to-br from-blue-500/20 to-indigo-500/10 p-6 transition hover:border-blue-400/50">
            <p class="text-sm font-semibold text-blue-300">{{ __('START A REVIEW') }}</p>
            <h2 class="mt-3 text-xl font-bold text-white">{{ __('Upload candidate resumes') }}</h2>
            <p class="mt-2 text-sm leading-6 text-slate-400">{{ __('Add resumes and a target job description to prepare a ranked review.') }}</p>
        </a>
        <a href="{{ route('dashboard.recruiter.candidates') }}"
            class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6 transition hover:border-slate-600">
            <p class="text-sm font-semibold text-indigo-300">{{ __('PIPELINE') }}</p>
            <h2 class="mt-3 text-xl font-bold text-white">{{ __('View candidates') }}</h2>
            <p class="mt-2 text-sm leading-6 text-slate-400">{{ __('Review ranking, skill alignment, and key gaps from one workspace.') }}</p>
        </a>
    </div>
</x-layouts.dashboard-layout>