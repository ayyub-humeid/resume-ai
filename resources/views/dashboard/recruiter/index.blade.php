<x-layouts.dashboard-layout title="Recruiter dashboard" heading="Hiring workspace" description="Organize applicant files, evaluate job fit, and build a high-confidence shortlist.">
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5"><p class="text-sm text-slate-400">Active roles</p><p class="mt-2 text-3xl font-bold text-white">0</p></div>
        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5"><p class="text-sm text-slate-400">Candidates reviewed</p><p class="mt-2 text-3xl font-bold text-white">0</p></div>
        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5"><p class="text-sm text-slate-400">Shortlisted</p><p class="mt-2 text-3xl font-bold text-white">0</p></div>
    </div>
    <div class="mt-8 grid gap-4 md:grid-cols-2">
        <a href="{{ route('dashboard.recruiter.bulk-upload') }}" class="rounded-2xl border border-blue-400/20 bg-gradient-to-br from-blue-500/20 to-indigo-500/10 p-6 transition hover:border-blue-400/50">
            <p class="text-sm font-semibold text-blue-300">START A REVIEW</p><h2 class="mt-3 text-xl font-bold text-white">Upload candidate resumes</h2><p class="mt-2 text-sm leading-6 text-slate-400">Add resumes and a target job description to prepare a ranked review.</p>
        </a>
        <a href="{{ route('dashboard.recruiter.candidates') }}" class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6 transition hover:border-slate-600">
            <p class="text-sm font-semibold text-indigo-300">PIPELINE</p><h2 class="mt-3 text-xl font-bold text-white">View candidates</h2><p class="mt-2 text-sm leading-6 text-slate-400">Review ranking, skill alignment, and key gaps from one workspace.</p>
        </a>
    </div>
</x-layouts.dashboard-layout>
