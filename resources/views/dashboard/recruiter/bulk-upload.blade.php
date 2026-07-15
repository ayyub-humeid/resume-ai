<x-layouts.dashboard-layout title="Bulk upload" heading="Start a candidate review" description="Add a job description and the resumes you want to evaluate against it.">
    <div class="grid max-w-5xl gap-5 lg:grid-cols-2">
        <section class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
            <h2 class="font-semibold text-white">Job description</h2>
            <p class="mt-1 text-sm text-slate-400">This becomes the benchmark for candidate ranking.</p>
            <label class="mt-5 block text-sm font-medium text-slate-200">Role title</label>
            <input class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950/50 px-4 py-3 text-white outline-none focus:border-blue-400" placeholder="Senior product designer">
            <label class="mt-5 block text-sm font-medium text-slate-200">Description</label>
            <textarea rows="8" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950/50 px-4 py-3 text-white outline-none focus:border-blue-400" placeholder="Paste the full job description…"></textarea>
        </section>
        <section class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
            <h2 class="font-semibold text-white">Candidate files</h2>
            <p class="mt-1 text-sm text-slate-400">Upload up to 10 PDF or Word resumes per review.</p>
            <div class="mt-5 grid min-h-64 place-items-center rounded-2xl border-2 border-dashed border-slate-700 bg-slate-950/40 p-6 text-center">
                <div><p class="font-medium text-white">Drop candidate resumes here</p><p class="mt-2 text-sm text-slate-500">PDF, DOC, or DOCX · maximum 10 files</p><button class="mt-5 rounded-lg border border-slate-600 px-4 py-2 text-sm font-semibold text-slate-200 hover:bg-slate-800">Choose files</button></div>
            </div>
            <button class="mt-5 w-full rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 py-3 font-semibold text-white hover:from-blue-400 hover:to-indigo-500">Analyze candidates</button>
        </section>
    </div>
</x-layouts.dashboard-layout>
