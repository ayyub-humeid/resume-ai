@props(['resumes'])

<section class="max-w-3xl rounded-2xl border border-slate-800 bg-slate-900/70 p-6 sm:p-8">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white">Create analysis</h2>
            <p class="mt-1 text-sm text-slate-400">Your resume is compared securely with the description you provide.</p>
        </div><button wire:click="index" class="text-sm font-semibold text-slate-400 hover:text-white">Back</button>
    </div>
    @if ($resumes->isEmpty())
        <div class="mt-8 rounded-xl border border-amber-500/30 bg-amber-500/10 p-4 text-sm text-amber-200">Upload a
            resume before creating an analysis.</div>
    @else
        <form wire:submit="runAnalysis" class="mt-8 space-y-6">
            <div><label for="resumeId" class="mb-2 block text-sm font-semibold text-white">Resume</label>
                <select id="resumeId" wire:model="resumeId"
                    class="w-full rounded-xl border border-slate-700 bg-slate-950/50 px-4 py-3 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20">
                    <option value="">Choose a resume…</option>
                    @foreach ($resumes as $resume)
                        <option value="{{ $resume->id }}">{{ $resume->title }} — {{ $resume->file_name }}</option>
                    @endforeach
                </select>
                @error('resumeId')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div><label for="jobTitle" class="mb-2 block text-sm font-semibold text-white">Job title</label>
                    <input id="jobTitle" wire:model="jobTitle" placeholder="e.g. Backend Developer"
                        class="w-full rounded-xl border border-slate-700 bg-slate-950/50 px-4 py-3 text-white placeholder-slate-600 focus:border-blue-400">
                    @error('jobTitle')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>
                <div><label for="company" class="mb-2 block text-sm font-semibold text-white">Company <span
                            class="text-slate-500">(optional)</span></label><input id="company" wire:model="company"
                        placeholder="e.g. Acme Inc."
                        class="w-full rounded-xl border border-slate-700 bg-slate-950/50 px-4 py-3 text-white placeholder-slate-600 focus:border-blue-400">
                </div>
            </div>
            <div><label for="jobDescription" class="mb-2 block text-sm font-semibold text-white">Job description</label>
                <textarea id="jobDescription" wire:model="jobDescription" rows="11"
                    placeholder="Paste the full role description, responsibilities, and requirements…"
                    class="w-full rounded-xl border border-slate-700 bg-slate-950/50 px-4 py-3 text-white placeholder-slate-600 focus:border-blue-400"></textarea>
                <p class="mt-2 text-xs text-slate-500">At least 80 characters. The fuller the description, the better
                    the feedback.</p>
                @error('jobDescription')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror @error('analysis')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" wire:loading.attr="disabled"
                class="w-full rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 py-3 font-bold text-white transition hover:from-blue-400 hover:to-indigo-500 disabled:opacity-60"><span
                    wire:loading.remove>Generate AI analysis</span><span wire:loading>Analyzing your
                    resume…</span></button>
        </form>
    @endif
</section>
