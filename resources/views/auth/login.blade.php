<x-layouts.app-layout pageTitle="{{ __('Sign in') }}" pageHeading="{{ __('Welcome back') }}"
    pageDescription="{{ __('Continue building a sharper hiring profile.') }}">

    <!-- تم تعديل الـ grid ليصبح md:grid-cols-2 لضمان ظهورهما بجانب بعض في الشاشات المتوسطة فما فوق -->
    <div class="mx-auto grid max-w-5xl gap-8 md:grid-cols-2 lg:items-center">

        <!-- تم تغيير hidden إلى md:block لضمان ظهورها بجانب النموذج -->
        <section
            class="hidden rounded-2xl border border-blue-500/20 bg-gradient-to-br from-blue-500/15 to-indigo-600/5 p-8 md:block">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-300">Resume AI</p>
            <h2 class="mt-4 text-4xl font-bold tracking-tight text-white">{{ __('Make every application count.') }}</h2>
            <p class="mt-4 max-w-md leading-7 text-slate-300">{{ __('Analyze your resume, spot improvement opportunities, and present your strongest work.') }}</p>
            <div class="mt-8 space-y-4 text-sm text-slate-300">
                <p>{{ __('✓ AI-guided resume feedback') }}</p>
                <p>{{ __('✓ ATS-focused improvements') }}</p>
                <p>{{ __('✓ Candidate review tools') }}</p>
            </div>
        </section>

        <form method="POST" action="{{ route('login') }}"
            class="rounded-2xl border border-slate-700/80 bg-slate-900/70 p-6 shadow-2xl shadow-black/20 sm:p-8">
            @csrf
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-400">{{ __('Secure sign in') }}</p>
            <h2 class="mt-2 text-2xl font-bold text-white">{{ __('Sign in to Resume AI') }}</h2>
            <p class="mt-1 text-sm text-slate-400">{{ __('Enter your details to continue.') }}</p>

            @if (session('status'))
                <div
                    class="mt-5 rounded-lg border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-300">
                    {{ session('status') }}</div>
            @endif

            <div class="mt-6 space-y-5">
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-200">{{ __('Email address') }}</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        autocomplete="email"
                        class="w-full rounded-lg border bg-slate-800 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30 @error('email') border-red-400 @else border-slate-700 @enderror"
                        placeholder="you@example.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <div class="mb-2 flex items-center justify-between">
                        <label for="password" class="text-sm font-medium text-slate-200">{{ __('Password') }}</label>
                        <a href="{{ route('password.request') }}"
                            class="text-sm font-medium text-blue-400 hover:text-blue-300">{{ __('Forgot password?') }}</a>
                    </div>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="w-full rounded-lg border bg-slate-800 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30 @error('password') border-red-400 @else border-slate-700 @enderror"
                        placeholder="{{ __('Your password') }}">
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-400">
                    <input type="checkbox" name="remember"
                        class="rounded border-slate-600 bg-slate-800 text-blue-500 focus:ring-blue-400">
                    {{ __('Keep me signed in') }}
                </label>
                <button type="submit"
                    class="w-full rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-3 font-semibold text-white shadow-lg shadow-blue-950/40 transition hover:from-blue-400 hover:to-indigo-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-slate-900">{{ __('Sign in') }}</button>
            </div>
            <p class="mt-6 text-center text-sm text-slate-400">{{ __('New to Resume AI?') }} <a href="{{ route('register') }}"
                    class="font-semibold text-blue-400 hover:text-blue-300">{{ __('Create an account') }}</a></p>
        </form>
    </div>
</x-layouts.app-layout>
