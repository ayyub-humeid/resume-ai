<div class="space-y-6">
    <div
        class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-800 bg-slate-900/70 p-6 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-xl font-bold text-white">{{ __('Candidate rankings') }}</h2>
            <p class="mt-1 text-sm text-slate-400">{{ __('Search, filter, and move candidates through your pipeline.') }}</p>
        </div><a href="{{ route('dashboard.recruiter.bulk-upload') }}{{ $jobFilter !== 'all' ? '?job_id=' . $jobFilter : '' }}"
            class="rounded-xl bg-blue-500 px-5 py-3 text-sm font-bold text-white hover:bg-blue-400">{{ __('New review') }}</a>
    </div>
    <div class="grid gap-3 rounded-2xl border border-slate-800 bg-slate-900/50 p-4 md:grid-cols-3">
        <input wire:model.live.debounce.300ms="search" type="search" placeholder="{{ __('Search candidates') }}"
            class="rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none focus:border-blue-500">
        <select wire:model.live="jobFilter"
            class="rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-2.5 text-sm text-white outline-none focus:border-blue-500">
            <option value="all">{{ __('All roles') }}</option>
            @foreach ($jobs as $job)
                <option value="{{ $job->id }}">{{ $job->title }}</option>
            @endforeach
        </select>
        <select wire:model.live="status"
            class="rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-2.5 text-sm text-white outline-none focus:border-blue-500">
            <option value="all">{{ __('All statuses') }}</option>
            <option value="new">{{ __('New') }}</option>
            <option value="reviewing">{{ __('Reviewing') }}</option>
            <option value="shortlisted">{{ __('Shortlisted') }}</option>
            <option value="rejected">{{ __('Rejected') }}</option>
        </select>
    </div>
    <div class="flex flex-wrap items-center gap-3 rounded-xl border border-slate-800 bg-slate-900/50 p-4">
        <button wire:click="reviewSelected" wire:loading.attr="disabled" wire:target="reviewSelected"
            class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white disabled:opacity-50 disabled:cursor-not-allowed">
            <span wire:loading.remove wire:target="reviewSelected">{{ __('Review selected') }}</span>
            <span wire:loading wire:target="reviewSelected">{{ __('Reviewing...') }}</span>
        </button>
        <button wire:click="reviewAll" wire:loading.attr="disabled" wire:target="reviewAll"
            class="rounded-lg border border-indigo-400/40 px-4 py-2 text-sm font-semibold text-indigo-200 disabled:opacity-50 disabled:cursor-not-allowed">
            <span wire:loading.remove wire:target="reviewAll">{{ __('Review all candidates in selected role') }}</span>
            <span wire:loading wire:target="reviewAll">{{ __('Reviewing...') }}</span>
        </button>
        <span class="text-sm text-slate-400">{{ __(':count selected', ['count' => count($selectedCandidates)]) }}</span>
    </div>
    @error('selection')
        <p class="text-sm text-rose-300">{{ $message }}</p>
    @enderror
    @forelse($candidates as $candidate)
        <article wire:key="candidate-{{ $candidate->id }}"
            class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                @if ($candidate->match_score === null)
                    <input wire:model.live="selectedCandidates" value="{{ $candidate->id }}" type="checkbox"
                        class="h-4 w-4 rounded border-slate-600 bg-slate-950 text-blue-500">
                @endif


                <div class="min-w-0 flex-1">
                    <h3 class="font-bold text-white">{{ $candidate->name }}</h3>
                    <p class="mt-1 text-sm text-slate-400">{{ $candidate->job?->title ?: __('Unassigned role') }} ·
                        {{ $candidate->file_name }} · {{ __(str_replace('_', ' ', $candidate->review_state)) }}</p>
                </div>
                <div class="flex items-center gap-3">
                    @if ($candidate->match_score !== null)
                        <span class="font-bold text-emerald-300">{{ $candidate->match_score }}%</span>
                    @endif
                    <select wire:change="updateStatus({{ $candidate->id }}, $event.target.value)"
                        class="rounded-lg border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-white outline-none focus:border-blue-500">
                        <option value="new" @selected($candidate->status === 'new')>{{ __('New') }}</option>
                        <option value="reviewing" @selected($candidate->status === 'reviewing')>{{ __('Reviewing') }}</option>
                        <option value="shortlisted" @selected($candidate->status === 'shortlisted')>{{ __('Shortlisted') }}</option>
                        <option value="rejected" @selected($candidate->status === 'rejected')>{{ __('Rejected') }}</option>
                    </select>
                </div>
            </div>
        </article>
    @empty
        <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-14 text-center">
            <p class="font-semibold text-white">{{ __('No candidates match your filters.') }}</p>
        </div>
    @endforelse
    <div>{{ $candidates->links() }}</div>
</div>
