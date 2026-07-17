<x-layouts.app-layout pageTitle="{{ __('Choose a new password') }}" pageHeading="{{ __('Set a new password') }}"
    pageDescription="{{ __('Choose a strong password you have not used before.') }}">
    <div class="mx-auto max-w-md rounded-2xl border border-slate-700/80 bg-slate-900/70 p-6 shadow-2xl shadow-black/20 sm:p-8">
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-400">{{ __('Account recovery') }}</p>
        <h2 class="mt-2 text-2xl font-bold text-white">{{ __('Create a new password') }}</h2>
        <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-slate-200">{{ __('Email address') }}</label>
                <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autocomplete="email"
                    class="w-full rounded-lg border bg-slate-800 px-4 py-3 text-white outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30 @error('email') border-red-400 @else border-slate-700 @enderror">
                @error('email') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-slate-200">{{ __('New password') }}</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                    class="w-full rounded-lg border bg-slate-800 px-4 py-3 text-white outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30 @error('password') border-red-400 @else border-slate-700 @enderror">
                @error('password') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-200">{{ __('Confirm new password') }}</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                    class="w-full rounded-lg border border-slate-700 bg-slate-800 px-4 py-3 text-white outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30">
            </div>
            <button type="submit" class="w-full rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-3 font-semibold text-white transition hover:from-blue-400 hover:to-indigo-500">{{ __('Reset password') }}</button>
        </form>
    </div>
</x-layouts.app-layout>
