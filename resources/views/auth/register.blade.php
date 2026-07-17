<x-layouts.app-layout pageTitle="{{ __('Create account') }}" pageHeading="{{ __('Start your next opportunity') }}"
    pageDescription="{{ __('Create a tailored workspace for your career goals.') }}">
    <div class="mx-auto max-w-2xl">
         <form method="POST" action="{{ route('register') }}"
            class="space-y-6 rounded-2xl border border-slate-700/80 bg-slate-900/70 p-6 shadow-2xl shadow-black/20 sm:p-8">
            @csrf

            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-400">Resume AI</p>
                <h2 class="mt-2 text-2xl font-bold text-white">{{ __('Create your account') }}</h2>
                <p class="mt-1 text-sm text-slate-400">{{ __('Choose how you plan to use Resume AI.') }}</p>
            </div>

            <fieldset>
                <legend class="mb-3 text-sm font-medium text-slate-200">{{ __('I am joining as a') }}</legend>
                <div class="grid  gap-3 sm:grid-cols-2">
                    <label class="cursor-pointer">
                        <input class="peer sr-only" type="radio" name="role" value="job_seeker"
                            @checked(old('role', 'job_seeker') === 'job_seeker')>
                        <span
                            class="block rounded-xl border border-slate-700 bg-slate-800/70 p-4 transition peer-checked:border-blue-400 peer-checked:bg-blue-500/10 peer-focus-visible:ring-2 peer-focus-visible:ring-blue-400">
                            <span class="block font-semibold text-white">{{ __('Job seeker') }}</span>
                            <span class="mt-1 block text-sm text-slate-400">{{ __('Improve resumes and prepare for interviews.') }}</span>
                        </span>
                    </label>
                    <label class="cursor-pointer">
                        <input class="peer sr-only" type="radio" name="role" value="recruiter"
                            @checked(old('role') === 'recruiter')>
                        <span
                            class="block rounded-xl border border-slate-700 bg-slate-800/70 p-4 transition peer-checked:border-blue-400 peer-checked:bg-blue-500/10 peer-focus-visible:ring-2 peer-focus-visible:ring-blue-400">
                            <span class="block font-semibold text-white">{{ __('Recruiter') }}</span>
                            <span class="mt-1 block text-sm text-slate-400">{{ __('Review and compare candidate resumes.') }}</span>
                        </span>
                    </label>
                </div>
                @error('role')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </fieldset>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-200">{{ __('Full name') }}</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        autocomplete="name"
                        class="w-full rounded-lg border bg-slate-800 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30 @error('name') border-red-400 @else border-slate-700 @enderror"
                        placeholder="Alex Morgan">
                    @error('name')
                        {{-- <p class="mt-2 text-sm text-red-400">{{ $message }}</p> --}}
                        <x-general-components.validation-input-error-message :message="$message" />
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-200">{{ __('Email address') }}</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        autocomplete="email"
                        class="w-full rounded-lg border bg-slate-800 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30 @error('email') border-red-400 @else border-slate-700 @enderror"
                        placeholder="you@example.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-200">{{ __('Password') }}</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="w-full rounded-lg border bg-slate-800 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30 @error('password') border-red-400 @else border-slate-700 @enderror"
                        placeholder="{{ __('At least 8 characters') }}">
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-200">{{ __('Confirm password') }}</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-slate-700 bg-slate-800 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30"
                        placeholder="{{ __('Repeat your password') }}">
                </div>
            </div>

            <button type="submit"
                class="w-full rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-3 font-semibold text-white shadow-lg shadow-blue-950/40 transition hover:from-blue-400 hover:to-indigo-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-slate-900">
                {{ __('Create account') }}
            </button>
            <p class="text-center text-sm text-slate-400">{{ __('Already have an account?') }} <a href="{{ route('login') }}"
                    class="font-semibold text-blue-400 hover:text-blue-300">{{ __('Sign in') }}</a></p>
        </form>
    </div>
</x-layouts.app-layout>
