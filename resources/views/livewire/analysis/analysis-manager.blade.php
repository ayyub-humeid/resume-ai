<div class="space-y-6">
    @if ($message)
        <div
            class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-300">
            {{ $message }}</div>
    @endif

    @if ($page === 'index')
        <div
            class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-800 bg-slate-900/70 p-6 sm:flex-row sm:items-center">
            <div>
                <h2 class="text-xl font-bold text-white">Your analyses</h2>
                <p class="mt-1 text-sm text-slate-400">Review each resume-to-role comparison in one place.</p>
            </div>
            <button wire:click="create"
                class="rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-3 text-sm font-bold text-white transition hover:from-blue-400 hover:to-indigo-500">New
                analysis</button>
        </div>

        @if (! $hasSavedAnalyses)
            <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-16 text-center">
                <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-blue-500/15 text-2xl text-blue-300">
                    ✦</div>
                <h3 class="mt-5 text-lg font-bold text-white">No analyses yet</h3>
                <p class="mx-auto mt-2 max-w-md text-sm text-slate-400">Choose one of your resumes and add a job
                    description to get tailored ATS feedback.</p>
                <button wire:click="create" class="mt-6 text-sm font-semibold text-blue-300 hover:text-blue-200">Create
                    your first analysis →</button>
            </div>
        @else
            <div class="grid gap-3 rounded-2xl border border-slate-800 bg-slate-900/50 p-4 sm:grid-cols-3">
                <input wire:model.live.debounce.300ms="search" type="search" placeholder="Search role, company, or resume"
                    class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none focus:border-blue-500">
                <select wire:model.live="resumeFilter" class="rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-2.5 text-sm text-white outline-none focus:border-blue-500">
                    <option value="all">All resumes</option>
                    @foreach ($resumes as $resume)
                        <option value="{{ $resume->id }}">{{ $resume->title }}</option>
                    @endforeach
                </select>
                <select wire:model.live="scoreFilter" class="rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-2.5 text-sm text-white outline-none focus:border-blue-500">
                    <option value="all">All match scores</option>
                    <option value="strong">Strong match (70%+)</option>
                    <option value="potential">Potential match (45–69%)</option>
                    <option value="needs-work">Needs work (under 45%)</option>
                </select>
            </div>

            @if ($analyses->isEmpty())
                <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-12 text-center">
                    <p class="text-sm font-medium text-slate-300">No analyses match these filters.</p>
                    <button wire:click="$set('search', ''); $set('resumeFilter', 'all'); $set('scoreFilter', 'all')" class="mt-3 text-sm font-semibold text-blue-300 hover:text-blue-200">Clear filters</button>
                </div>
            @else
            <div class="grid gap-4">
                @foreach ($analyses as $analysis)
                    <article wire:key="analysis-{{ $analysis->id }}"
                        class="group rounded-2xl border border-slate-800 bg-slate-900/60 p-5 transition hover:border-slate-600 hover:bg-slate-900">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                            <div
                                class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl {{ $analysis->match_score >= 70 ? 'bg-emerald-500/15 text-emerald-300' : ($analysis->match_score >= 45 ? 'bg-amber-500/15 text-amber-300' : 'bg-rose-500/15 text-rose-300') }}">
                                <span class="text-lg font-black">{{ $analysis->match_score }}%</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="truncate font-bold text-white">{{ $analysis->job->title }}</h3>
                                <p class="mt-1 text-sm text-slate-400">
                                    {{ $analysis->job->company ?: 'Company not specified' }} ·
                                    {{ $analysis->resume->title }}</p>
                                <p class="mt-2 text-xs text-slate-500">Created
                                    {{ $analysis->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex gap-2"><button wire:click="show({{ $analysis->id }})"
                                    class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">View</button><button
                                    {{-- wire:click="askToDelete({{ $analysis->id }})" --}} wire:click="delete({{ $analysis->id }})"
                                    wire:confirm="Delete this analysis?"
                                    class="rounded-lg px-3 py-2 text-sm text-slate-500 hover:bg-red-500/10 hover:text-red-300"
                                    aria-label="Delete analysis">Delete</button></div>
                        </div>
                    </article>
                @endforeach
            </div>
            @endif
        @endif
    @elseif ($page === 'create')
        <x-analysis.create :resumes="$resumes" />
    @elseif ($selectedAnalysis)
        <x-analysis.show :analysis="$selectedAnalysis" :draft-cover-letter="$draftCoverLetter" :show-cover-letter-review="$showCoverLetterReview" />
    @endif

    <x-general-components.confirmation-modal title="Delete analysis?"
        message="The saved feedback and its job description will be permanently removed." />
</div>
