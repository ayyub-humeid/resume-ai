<x-layouts.dashboard-layout title="Candidates" heading="Candidate rankings" description="Your analyzed candidates will appear here, ordered by match quality.">
    <livewire:recruiter.candidate-manager />
    {{-- <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4"><div><h2 class="font-semibold text-white">No candidates yet</h2><p class="mt-1 text-sm text-slate-400">Create a review to upload resumes and rank them against a role.</p></div><a href="{{ route('dashboard.recruiter.bulk-upload') }}" class="rounded-lg bg-blue-500 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-400">New review</a></div>
    </div> --}}
</x-layouts.dashboard-layout>
