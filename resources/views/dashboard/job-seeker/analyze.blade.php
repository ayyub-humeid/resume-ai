<x-layouts.dashboard-layout title="Analyze a role" heading="Analyze a role" description="Compare a saved resume with a job description and identify the strongest next improvements.">
    <div class="max-w-3xl rounded-2xl border border-slate-800 bg-slate-900/70 p-6 sm:p-8">

            <!-- Form -->
            <form class="space-y-6">
                <!-- Resume Selection -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-3">Select Resume</label>
                    <select class="w-full rounded-xl border border-slate-700 bg-slate-950/50 px-4 py-3 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20">
                        <option value="">Choose a resume...</option>
                    </select>
                </div>

                <!-- Job Description -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-3">Job Description</label>
                    <textarea rows="8" placeholder="Paste the job description here..."
                        class="w-full rounded-xl border border-slate-700 bg-slate-950/50 px-4 py-3 text-white placeholder-slate-500 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 py-3 font-semibold text-white transition hover:from-blue-400 hover:to-indigo-500">
                    Analyze Now
                </button>
            </form>
        </div>
    </div>
</x-layouts.dashboard-layout>
