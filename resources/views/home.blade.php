<x-layouts.public-layout title="{{ __('AI resume intelligence') }}">
    <main>
        <section class="mx-auto max-w-7xl px-5 pb-24 pt-20 sm:px-8 sm:pt-28">
            <div class="mx-auto max-w-3xl text-center">
                <div class="inline-flex items-center gap-2 rounded-full border border-blue-400/20 bg-blue-400/10 px-3 py-1 text-xs font-semibold text-blue-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-blue-300"></span> {{ __('AI-powered career intelligence') }}
                </div>
                <h1 class="mt-7 text-5xl font-bold tracking-tight text-white sm:text-6xl">{{ __('Make every application') }} <span class="bg-gradient-to-r from-blue-300 to-indigo-400 bg-clip-text text-transparent">{{ __('count.') }}</span></h1>
                <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-slate-400">{{ __('Resume AI turns resumes and job descriptions into clear next steps—whether you are pursuing your next role or building a better shortlist.') }}</p>
                <div class="mt-9 flex flex-col justify-center gap-3 sm:flex-row">
                    @auth
                        <a href="{{ auth()->user()->getDashboardUrl() }}" class="rounded-xl bg-blue-500 px-6 py-3 font-semibold text-white shadow-lg shadow-blue-950/50 transition hover:bg-blue-400">{{ __('Go to my dashboard') }}</a>
                    @else
                        <a href="{{ route('register') }}" class="rounded-xl bg-blue-500 px-6 py-3 font-semibold text-white shadow-lg shadow-blue-950/50 transition hover:bg-blue-400">{{ __('Create a free account') }}</a>
                        <a href="{{ route('login') }}" class="rounded-xl border border-slate-700 px-6 py-3 font-semibold text-slate-200 transition hover:border-slate-500 hover:bg-slate-900">{{ __('Sign in') }}</a>
                    @endauth
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-5 pb-24 sm:px-8">
            <div class="grid gap-5 md:grid-cols-3">
                <article class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-blue-500/15 font-bold text-blue-300">01</span>
                    <h2 class="mt-5 text-lg font-semibold text-white">{{ __('Upload with confidence') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-400">{{ __('Keep your resumes organized and ready to tailor for the next opportunity.') }}</p>
                </article>
                <article class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-indigo-500/15 font-bold text-indigo-300">02</span>
                    <h2 class="mt-5 text-lg font-semibold text-white">{{ __('Understand the match') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-400">{{ __('Compare skills, missing keywords, ATS readiness, and the job requirements in one clear view.') }}</p>
                </article>
                <article class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-emerald-500/15 font-bold text-emerald-300">03</span>
                    <h2 class="mt-5 text-lg font-semibold text-white">{{ __('Make stronger decisions') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-400">{{ __('Candidates prepare smarter. Recruiters review and rank with more context.') }}</p>
                </article>
            </div>
        </section>

        <section class="border-y border-slate-800 bg-slate-900/40">
            <div class="mx-auto grid max-w-7xl gap-5 px-5 py-16 sm:px-8 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-800 bg-slate-950/50 p-7">
                    <p class="text-sm font-semibold text-blue-300">{{ __('For job seekers') }}</p>
                    <h2 class="mt-3 text-2xl font-bold text-white">{{ __('Present your strongest story.') }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-400">{{ __('Analyze role fit, improve ATS compatibility, and prepare for the interview questions that matter.') }}</p>
                </div>
                <div class="rounded-2xl border border-slate-800 bg-slate-950/50 p-7">
                    <p class="text-sm font-semibold text-indigo-300">{{ __('For recruiters') }}</p>
                    <h2 class="mt-3 text-2xl font-bold text-white">{{ __('Find signal in every application.') }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-400">{{ __('Upload candidates, rank job fit, and build a shortlist your team can trust.') }}</p>
                </div>
            </div>
        </section>
    </main>
</x-layouts.public-layout>
