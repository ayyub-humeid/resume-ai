<div class="space-y-6">
    @if ($pageState === 'index')
        <!-- Header -->
        <div
            class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-800 bg-slate-900/70 p-6 sm:flex-row sm:items-center">
            <div>
                <h2 class="text-xl font-bold text-white">{{ __('Job Listings') }}</h2>
                <p class="mt-1 text-sm text-slate-400">{{ __('Manage your open roles and track candidates.') }}</p>
            </div>
            <button wire:click="changeState('create')"
                class="rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-3 text-sm font-bold text-white transition hover:from-blue-400 hover:to-indigo-500">
                {{ __('Post New Job') }}
            </button>
        </div>

        <!-- Filters -->
        <div class="rounded-2xl gap-2  flex  border border-slate-800 bg-slate-900/50 p-4">
            <input wire:model.live.debounce.300ms="search" type="search" placeholder="{{ __('Search roles or companies') }}"
                class="w-[40%] sm:max-w-md rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none focus:border-blue-500">
            <select wire:model.live="filterstatus"
                class="rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-2.5 text-sm text-white outline-none focus:border-blue-500">
                <option value="all">{{ __('All statuses') }}</option>
                <option value="open">{{ __('Open') }}</option>
                <!-- <option value="active">Active</option> -->
                <option value="closed">{{ __('Closed') }}</option>


            </select>
        </div>

        <!-- Job List -->
        @if ($jobs->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-16 text-center">
                <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-blue-500/15 text-2xl text-blue-300">
                    <span class="material-symbols-outlined">work</span>
                </div>
                <h3 class="mt-5 text-lg font-bold text-white">{{ __('No jobs found') }}</h3>
                <p class="mx-auto mt-2 max-w-md text-sm text-slate-400">{{ __("You haven't created any job listings yet, or none match your search.") }}</p>
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($jobs as $job)
                    <article wire:key="job-{{ $job->id }}"
                        class="flex flex-col justify-between rounded-2xl border border-slate-800 bg-slate-900/60 p-5 transition hover:border-slate-600 hover:bg-slate-900">
                        <div>
                            <div class="flex items-start justify-between">
                                <div class="rounded-lg bg-blue-500/10 p-2 text-blue-400">
                                    <span class="material-symbols-outlined">work</span>
                                </div>
                                <span
                                    class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $job->status === 'open' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-slate-800 text-slate-400' }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </div>
                            <h3 class="mt-4 truncate text-lg font-bold text-white">{{ $job->title }}</h3>
                            <p class="truncate text-sm text-slate-400">{{ $job->company ?: __('No company specified') }}</p>
                        </div>

                        <div class="mt-6 flex items-center justify-between border-t border-slate-800 pt-4">
                            <div class="text-sm font-medium text-slate-300">
                                {{ __(':count candidates', ['count' => $job->candidates_count]) }}
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="changeState('show', {{ $job->id }})"
                                    class="rounded-lg bg-slate-800 px-3 py-1.5 text-sm font-semibold text-white transition hover:bg-slate-700">{{ __('View') }}</button>
                                <button wire:click="changeState('edit', {{ $job->id }})"
                                    class="rounded-lg border border-slate-700 px-3 py-1.5 text-sm font-semibold text-slate-300 transition hover:bg-slate-800 hover:text-white">{{ __('Edit') }}</button>
                                <button type="button"
                                    onclick="confirmAction('{{ __('Permanently delete this job and all associated candidate data?') }}', () => @this.delete({{ $job->id }}), '{{ __('Delete Job') }}')"
                                    class="rounded-lg px-2 py-1.5 text-slate-500 transition hover:bg-red-500/10 hover:text-red-400">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            <div>{{ $jobs->links() }}</div>
        @endif

    @elseif (in_array($pageState, ['create', 'edit']))
        <!-- Form -->
        <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6 sm:p-8 max-w-3xl mx-auto">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <button wire:click="changeState('index')"
                                class="mb-2 flex items-center gap-1 text-sm font-semibold text-blue-400 hover:text-blue-300">
                                <span class="material-symbols-outlined text-[18px]">arrow_back</span> {{ __('Back to jobs') }}
                            </button>
                            <h2 class="text-2xl font-bold text-white">{{ $pageState === 'create' ? __('Post New Job') : __('Edit Job') }}
                            </h2>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-300">{{ __('Job Title') }} <span
                                class="text-red-400">*</span></label>
                        <input type="text" wire:model="title"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-sm text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            placeholder="{{ __('e.g. Senior Frontend Engineer') }}">
                        @error('title') <span class="mt-1 block text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-300">{{ __('Company') }}</label>
                        <input type="text" wire:model="company"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-sm text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            placeholder="{{ __('Your company name') }}">
                        @error('company') <span class="mt-1 block text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-300">{{ __('Source URL') }}</label>
                    <input type="url" wire:model="source_url"
                        class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-sm text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        placeholder="https://...">
                    @error('source_url') <span class="mt-1 block text-xs text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-300">{{ __('Job Status') }}</label>
                    <select wire:model="status"
                        class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-sm text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="open">{{ __('Open (Accepting candidates)') }}</option>
                        <option value="closed">{{ __('Closed') }}</option>
                    </select>
                    @error('status') <span class="mt-1 block text-xs text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-300">{{ __('Job Description') }} <span
                            class="text-red-400">*</span></label>
                    <textarea wire:model="description" rows="6"
                        class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-sm text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        placeholder="{{ __('Paste the full job description here...') }}"></textarea>
                    @error('description') <span class="mt-1 block text-xs text-red-400">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" wire:click="changeState('index')"
                        class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-300 hover:bg-slate-800 transition">{{ __('Cancel') }}</button>
                    <button type="submit"
                        class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white transition hover:bg-blue-500">
                        {{ $pageState === 'create' ? __('Create Job') : __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>

    @elseif ($pageState === 'show' && $selectedJob)
        <!-- Show Job Details -->
        <div>
            <button wire:click="changeState('index')"
                class="mb-4 flex items-center gap-1 text-sm font-semibold text-blue-400 hover:text-blue-300">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span> {{ __('Back to jobs') }}
            </button>

            <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6 lg:p-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <div class="flex items-center gap-3">
                            <h2 class="text-3xl font-bold text-white">{{ $selectedJob->title }}</h2>
                            <span
                                class="rounded-full px-3 py-1 text-xs font-semibold {{ $selectedJob->status === 'open' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-slate-800 text-slate-400 border border-slate-700' }}">
                                {{ ucfirst($selectedJob->status) }}
                            </span>
                        </div>
                        <p class="mt-2 text-lg text-slate-400">{{ $selectedJob->company ?: __('Company not specified') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button wire:click="changeState('showCandidates', {{ $selectedJob->id }})"
                            class="flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                            <span class="material-symbols-outlined text-[18px]">group</span> {{ __('View Rankings') }}
                        </button>
                        <button wire:click="changeState('edit', {{ $selectedJob->id }})"
                            class="flex items-center gap-2 rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">
                            <span class="material-symbols-outlined text-[18px]">edit</span> {{ __('Edit Job') }}
                        </button>
                        <button type="button"
                            onclick="confirmAction('{{ __('Permanently delete this job?') }}', () => @this.delete({{ $selectedJob->id }}), '{{ __('Delete Job') }}')"
                            class="flex items-center gap-2 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-2.5 text-sm font-semibold text-red-400 transition hover:bg-red-500/20">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>
                </div>

                <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_300px]">
                    <div class="rounded-xl border border-slate-800 bg-slate-900/40 p-6">
                        <h3 class="text-lg font-semibold text-white border-b border-slate-800 pb-3 mb-4">{{ __('Job Description') }}</h3>
                        <div class="text-sm text-slate-300 whitespace-pre-wrap leading-relaxed">
                            {{ $selectedJob->description }}
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-xl border border-slate-800 bg-slate-900/50 p-5">
                            <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">{{ __('Quick Stats') }}</h3>
                            <div class="mt-4 grid gap-4">
                                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                                    <span class="text-sm text-slate-400">{{ __('Total Candidates') }}</span>
                                    <span class="text-2xl font-bold text-white">{{ $selectedJob->candidates_count }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-slate-400">{{ __('Created') }}</span>
                                    <span
                                        class="text-sm font-medium text-white">{{ $selectedJob->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        @if ($selectedJob->source_url)
                            <div class="rounded-xl border border-slate-800 bg-slate-900/50 p-5">
                                <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">{{ __('Source Link') }}</h3>
                                <a href="{{ $selectedJob->source_url }}" target="_blank"
                                    class="mt-3 inline-flex items-center gap-2 text-sm font-medium text-blue-400 hover:text-blue-300">
                                    {{ __('View original posting') }} <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Embedded Candidates Section for this Job -->
            <div class="mt-8">
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">{{ __('Candidates for this role') }}</h3>
                </div>
                <!-- Clean integration of the candidate manager locked to this job -->
                <livewire:recruiter.candidate-manager :jobFilter="(string) $selectedJob->id" :key="'candidates-' . $selectedJob->id" />
            </div>
        </div>
    @elseif ($pageState === 'showCandidates' && $selectedJob)
        <!-- Candidate Rankings View -->
        <div>
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <button wire:click="changeState('show', {{ $selectedJob->id }})"
                        class="mb-2 flex items-center gap-1 text-sm font-semibold text-blue-400 hover:text-blue-300">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span> {{ __('Back to job details') }}
                    </button>
                    <h2 class="text-2xl font-bold text-white">{{ __('Ranked Candidates') }}</h2>
                    <p class="mt-1 text-slate-400">{{ __('Showing all :count candidates for :title', ['count' => $selectedJob->candidates_count, 'title' => $selectedJob->title]) }}</p>
                </div>
            </div>

            @if($rankedCandidates->isEmpty())
                <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-16 text-center">
                    <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-blue-500/15 text-2xl text-blue-300">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-white">{{ __('No candidates yet') }}</h3>
                    <p class="mx-auto mt-2 max-w-md text-sm text-slate-400">{{ __("You haven't uploaded or linked any candidates to this job.") }}</p>
                </div>
            @else
                <!-- Top 3 Podium -->
                @if($rankedCandidates->count() >= 3 && $rankedCandidates[0]->match_score !== null)
                    <div class="mb-10 grid gap-4 sm:grid-cols-3 lg:gap-6">
                        @foreach($rankedCandidates->take(3) as $index => $topCandidate)
                            @php
                                $rankColors = [
                                    0 => 'from-yellow-500/20 to-amber-600/10 border-yellow-500/30 text-yellow-500', // Gold
                                    1 => 'from-slate-300/20 to-slate-400/10 border-slate-300/30 text-slate-300',    // Silver
                                    2 => 'from-orange-500/20 to-amber-700/10 border-orange-500/30 text-orange-400'  // Bronze
                                ];
                                $rankStyle = $rankColors[$index];
                            @endphp
                            <div class="relative overflow-hidden rounded-2xl border bg-gradient-to-b {{ $rankStyle }} p-6 text-center shadow-lg backdrop-blur-sm transition hover:scale-[1.02]">
                                <div class="absolute -right-4 -top-4 text-[80px] opacity-10">
                                    <span class="material-symbols-outlined">trophy</span>
                                </div>
                                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-900/50 text-2xl font-black shadow-inner">
                                    {{ $topCandidate->match_score }}%
                                </div>
                                <h3 class="truncate text-lg font-bold text-white">{{ $topCandidate->name }}</h3>
                                <p class="truncate text-sm text-slate-400">{{ $topCandidate->file_name }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Detailed Candidate List -->
                <div class="grid gap-4">
                    @foreach($rankedCandidates as $candidate)
                        <article class="flex flex-col gap-6 rounded-2xl border border-slate-800 bg-slate-900/60 p-6 transition hover:border-slate-700 hover:bg-slate-900 lg:flex-row lg:items-center">
                            
                            <!-- Score & Basic Info -->
                            <div class="flex flex-1 items-center gap-6">
                                <div class="relative flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-full border-4 {{ $candidate->match_score >= 75 ? 'border-emerald-500/30 text-emerald-400' : ($candidate->match_score >= 50 ? 'border-amber-500/30 text-amber-400' : 'border-rose-500/30 text-rose-400') }} bg-slate-950 shadow-inner">
                                    @if($candidate->match_score !== null)
                                        <span class="text-xl font-black">{{ $candidate->match_score }}<span class="text-xs">%</span></span>
                                    @else
                                        <span class="text-sm font-semibold text-slate-500">{{ __('N/A') }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h3 class="truncate text-xl font-bold text-white">{{ $candidate->name }}</h3>
                                    <div class="mt-1 flex flex-wrap items-center gap-3 text-sm text-slate-400">
                                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">description</span> {{ $candidate->file_name }}</span>
                                        <span class="rounded-full bg-slate-800 px-2.5 py-0.5 text-xs font-semibold text-slate-300">{{ __('Status: :status', ['status' => __($candidate->status)]) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- AI Analysis Snippet -->
                            @if(!empty($candidate->review_data))
                                <div class="flex-1 rounded-xl border border-indigo-500/10 bg-indigo-500/5 p-4 text-sm leading-relaxed text-indigo-200">
                                    @if(!empty($candidate->review_data['keywords_matched']))
                                        <p><strong class="text-indigo-300">{{ __('Matched Skills:') }}</strong> {{ implode(', ', array_slice($candidate->review_data['keywords_matched'], 0, 5)) }}{{ count($candidate->review_data['keywords_matched']) > 5 ? '...' : '' }}</p>
                                    @endif
                                    @if(!empty($candidate->review_data['keywords_missing']))
                                        <p class="mt-2 text-rose-300/80"><strong class="text-rose-300">{{ __('Missing:') }}</strong> {{ implode(', ', array_slice($candidate->review_data['keywords_missing'], 0, 3)) }}{{ count($candidate->review_data['keywords_missing']) > 3 ? '...' : '' }}</p>
                                    @endif
                                </div>
                            @else
                                <div class="flex-1 text-sm italic text-slate-500">
                                    {{ __('No AI analysis available for this candidate yet.') }}
                                </div>
                            @endif

                            <!-- Quick Actions -->
                            <div class="flex flex-shrink-0 gap-2 border-t border-slate-800 pt-4 lg:border-t-0 lg:pt-0">
                                <button wire:click="updateCandidateStatus({{ $candidate->id }}, 'shortlisted')" 
                                        class="flex h-10 w-10 items-center justify-center rounded-xl transition {{ $candidate->status === 'shortlisted' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'border border-slate-700 bg-slate-800 text-slate-400 hover:border-emerald-500/50 hover:text-emerald-400' }}"
                                        title="Shortlist">
                                    <span class="material-symbols-outlined text-[20px]">thumb_up</span>
                                </button>
                                <button wire:click="updateCandidateStatus({{ $candidate->id }}, 'rejected')" 
                                        class="flex h-10 w-10 items-center justify-center rounded-xl transition {{ $candidate->status === 'rejected' ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/20' : 'border border-slate-700 bg-slate-800 text-slate-400 hover:border-rose-500/50 hover:text-rose-400' }}"
                                        title="Reject">
                                    <span class="material-symbols-outlined text-[20px]">thumb_down</span>
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>