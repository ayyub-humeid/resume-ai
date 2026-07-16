<div class="space-y-8">
    <div class="grid gap-4 sm:grid-cols-3">
        <x-dashboard.stat-card label="Active roles" :value="$activeRoles" />
        <x-dashboard.stat-card label="Candidates reviewed" :value="$candidateCount" tone="indigo" />
        <x-dashboard.stat-card label="Shortlisted" :value="$shortlistedCount" tone="emerald" />
    </div>

    <div
        class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-800 bg-slate-900/70 p-6 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-xl font-bold text-white">Your roles</h2>
            <p class="mt-1 text-sm text-slate-400">Manage the roles and candidate reviews in your pipeline.</p>
        </div>
        <a href="{{ route('dashboard.recruiter.bulk-upload') }}"
            class="rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-3 text-sm font-bold text-white hover:from-blue-400 hover:to-indigo-500">New
            review</a>
    </div>

    <div class="grid gap-3 rounded-2xl border border-slate-800 bg-slate-900/50 p-4 sm:grid-cols-[1fr_auto]">
        <input wire:model.live.debounce.300ms="search" type="search" placeholder="Search roles or companies"
            class="rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none focus:border-blue-500">
        <select wire:model.live="status"
            class="rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-2.5 text-sm text-white outline-none focus:border-blue-500">
            <option value="active">Active roles</option>
            <option value="archived">Archived roles</option>
            <option value="all">All roles</option>
        </select>
    </div>

    @if ($jobs->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-14 text-center">
            <p class="font-semibold text-white">No roles match your filters.</p><a
                href="{{ route('dashboard.recruiter.bulk-upload') }}"
                class="mt-3 inline-block text-sm font-semibold text-blue-300 hover:text-blue-200">Start a candidate
                review</a>
        </div>
    @else
        <div class="grid gap-4">
            @foreach ($jobs as $job)
                <article wire:key="job-{{ $job->id }}"
                    class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <h3 class="truncate font-bold text-white">{{ $job->title }}</h3><span
                                    class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $job->status === 'active' ? 'bg-emerald-500/15 text-emerald-300' : 'bg-slate-700 text-slate-300' }}">{{ ucfirst($job->status) }}</span>
                            </div>
                            <p class="mt-1 text-sm text-slate-400">{{ $job->company ?: 'Company not specified' }} ·
                                {{ $job->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex items-center gap-3"><span
                                class="text-sm text-slate-400">{{ $job->candidates_count }} candidates</span><button
                                wire:click="toggleStatus({{ $job->id }})"
                                class="rounded-lg bg-slate-800 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-700">{{ $job->status === 'active' ? 'Archive' : 'Restore' }}</button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        <div>{{ $jobs->links() }}</div>
    @endif
</div>
