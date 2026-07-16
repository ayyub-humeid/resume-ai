@props(['analysis', 'draftCoverLetter' => null, 'showCoverLetterReview' => false])
<section class="space-y-6">
    <div
        class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-800 bg-slate-900/70 p-6 sm:flex-row sm:items-center">
        <div><button wire:click="index" class="text-sm font-semibold text-slate-400 hover:text-white">← All
                analyses</button>
            <h2 class="mt-3 text-2xl font-bold text-white">{{ $analysis->job->title }}</h2>
            <p class="mt-1 text-sm text-slate-400">{{ $analysis->job->company ?: 'Company not specified' }} ·
                {{ $analysis->resume->title }}</p>
        </div>
        <div
            class="grid h-24 w-24 place-items-center rounded-full border-8 {{ $analysis->match_score >= 70 ? 'border-emerald-500/30 text-emerald-300' : 'border-amber-500/30 text-amber-300' }}">
            <div class="text-center">
                <div class="text-2xl font-black">{{ $analysis->match_score }}%</div>
                <div class="text-[10px] font-bold uppercase tracking-wider">Match</div>
            </div>
        </div>
    </div>
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6">
            <h3 class="font-bold text-white">Matched keywords</h3>
            <div class="mt-4 flex flex-wrap gap-2">
                @forelse($analysis->keywords_matched ?? [] as $keyword)
                    <span
                    class="rounded-full bg-emerald-500/10 px-3 py-1 text-sm text-emerald-300">{{ $keyword }}</span>@empty
                    <p class="text-sm text-slate-500">No matched keywords returned.</p>
                @endforelse
            </div>
        </div>
        <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6">
            <h3 class="font-bold text-white">Missing keywords</h3>
            <div class="mt-4 flex flex-wrap gap-2">
                @forelse($analysis->keywords_missing ?? [] as $keyword)
                    <span
                    class="rounded-full bg-amber-500/10 px-3 py-1 text-sm text-amber-200">{{ $keyword }}</span>@empty
                    <p class="text-sm text-slate-500">No missing keywords returned.</p>
                @endforelse
            </div>
        </div>
        <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6">
            <h3 class="font-bold text-white">ATS improvements</h3>
            <ul class="mt-4 space-y-3">
                @forelse($analysis->ats_issues ?? [] as $issue)
                    <li class="flex gap-3 text-sm leading-6 text-slate-300"><span
                            class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-blue-400"></span>{{ $issue }}</li>
                @empty<p class="text-sm text-slate-500">No issues returned.</p>
                @endforelse
            </ul>
        </div>
        <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6">
            <h3 class="font-bold text-white">Interview questions</h3>
            <ol class="mt-4 space-y-3">
                @forelse($analysis->interview_questions ?? [] as $question)
                <li class="text-sm leading-6 text-slate-300">{{ $loop->iteration }}. {{ $question }}</li>@empty
                    <p class="text-sm text-slate-500">No questions returned.</p>
                @endforelse
            </ol>
        </div>
    </div>

    {{-- cover letter side --}}
    <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6">
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-white">Tailored cover letter</h3>

            @if (!$showCoverLetterReview)
                <button wire:click="generateCoverLetter" wire:loading.attr="disabled" wire:target="generateCoverLetter"
                    class="rounded-lg bg-emerald-500/30 px-4 py-2 text-sm font-semibold text-emerald-200 hover:bg-emerald-500/40 disabled:opacity-50">
                    <span wire:loading.remove wire:target="generateCoverLetter">
                        {{ $analysis->cover_letter ? 'Regenerate cover letter' : 'Generate cover letter' }}
                    </span>
                    <span wire:loading wire:target="generateCoverLetter">Generating…</span>
                </button>
            @endif
        </div>

        @error('coverLetter')
            <p class="mt-3 text-sm text-red-400">{{ $message }}</p>
        @enderror

        {{-- Draft under review: not saved yet --}}
        @if ($showCoverLetterReview && $draftCoverLetter)
            <div class="mt-4 rounded-xl border border-amber-500/30 bg-amber-500/5 p-4">
                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-amber-300">
                    Draft — not saved yet
                </p>
                <div class="whitespace-pre-line text-sm leading-7 text-slate-200">
                    {{ $draftCoverLetter }}
                </div>

                <div class="mt-5 flex gap-3">
                    <button wire:click="approveCoverLetter"
                        class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400">
                        Approve & Save
                    </button>
                    <button wire:click="cancelCoverLetter"
                        class="rounded-lg border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-300 hover:bg-slate-800">
                        Discard
                    </button>
                    <button wire:click="generateCoverLetter"
                        class="rounded-lg border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-300 hover:bg-slate-800">
                        Regenerate
                    </button>
                </div>
            </div>
        @elseif($analysis->cover_letter)
            {{-- Already-approved, persisted cover letter --}}
            <div class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-300">
                {{ $analysis->cover_letter }}
            </div>
        @else
            <p class="mt-4 text-sm text-slate-500">No cover letter generated yet.</p>
        @endif
    </div>
</section>
