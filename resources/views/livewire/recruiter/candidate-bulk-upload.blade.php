<div class="space-y-6">
    @if ($message)
        <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
            {{ $message }}</div>
    @endif
    <form wire:submit="submit" class="grid max-w-5xl gap-5 lg:grid-cols-2">
        <section class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
            <h2 class="font-semibold text-white">Role details</h2>
            <label class="mt-5 block text-sm text-slate-200">Add to
                an existing role</label>
            <select wire:model.live="existingJobId"
                class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950/50 px-4 py-3 text-white">
                <option value="">Create a new role</option>
                @foreach ($jobs as $job)
                    <option value="{{ $job->id }}">{{ $job->title }}</option>
                @endforeach
            </select>
            @if ($existingJobId === '')
                <label class="mt-5 block text-sm text-slate-200">Role
                    title</label>
                <input wire:model="jobTitle"
                    class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950/50 px-4 py-3 text-white"
                    placeholder="Senior product designer">
                @error('jobTitle')
                    <p class="mt-1 text-sm text-rose-300">{{ $message }}</p>
                @enderror
                <label class="mt-5 block text-sm text-slate-200">
                    Company</label><input wire:model="company"
                    class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950/50 px-4 py-3 text-white"
                    placeholder="Acme Inc."><label class="mt-5 block text-sm text-slate-200">Job description</label>
                <textarea wire:model="jobDescription" rows="8"
                    class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950/50 px-4 py-3 text-white"
                    placeholder="Paste the full job description"></textarea>
                @error('jobDescription')
                    <p class="mt-1 text-sm text-rose-300">{{ $message }}</p>
                @enderror
            @endif
        </section>
        <section class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
            <h2 class="font-semibold text-white">Candidate files</h2><label
                class="mt-5 grid min-h-64 cursor-pointer place-items-center rounded-2xl border-2 border-dashed border-slate-700 bg-slate-950/40 p-6 text-center">
                <input wire:model="files" type="file" accept=".pdf,.doc,.docx" multiple class="sr-only"><span
                    class="font-medium text-white">Choose up to 10 resumes</span></label>
            @error('files')
                {{-- <p class="mt-2 text-sm text-rose-300">{{ $message }}</p> --}}
                <x-general-components.validation-input-error-message :message="$message" />
            @enderror
            @if ($files)
                <p class="mt-4 text-sm text-slate-300">{{ count($files) }} file(s) ready</p>
            @endif
            <button type="submit" wire:loading.attr="disabled"
                class="mt-5 w-full rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 py-3 font-semibold text-white"><span
                    wire:loading.remove>Start review</span><span wire:loading>Uploading…</span></button>
        </section>
    </form>
</div>
