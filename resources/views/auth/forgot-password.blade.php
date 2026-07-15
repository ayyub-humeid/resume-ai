<x-layouts.app-layout pageTitle="Forgot password" pageHeading="Reset your password"
    pageDescription="We'll send a secure password-reset link to your email.">
    <div class="mx-auto max-w-md rounded-2xl border border-slate-700/80 bg-slate-900/70 p-6 shadow-2xl shadow-black/20 sm:p-8">
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-400">Account recovery</p>
        <h2 class="mt-2 text-2xl font-bold text-white">Forgot your password?</h2>
        <p class="mt-2 text-sm leading-6 text-slate-400">Enter the email address associated with your account and we'll send a reset link.</p>
        @if (session('status'))
            <div class="mt-5 rounded-lg border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-300">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
            @csrf
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-slate-200">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                    class="w-full rounded-lg border bg-slate-800 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30 @error('email') border-red-400 @else border-slate-700 @enderror" placeholder="you@example.com">
                @error('email') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="w-full rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-3 font-semibold text-white transition hover:from-blue-400 hover:to-indigo-500">Email reset link</button>
        </form>
        <p class="mt-6 text-center text-sm text-slate-400"><a href="{{ route('login') }}" class="font-semibold text-blue-400 hover:text-blue-300">Back to sign in</a></p>
    </div>
</x-layouts.app-layout>
