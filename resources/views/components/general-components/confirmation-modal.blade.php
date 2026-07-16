@props(['title' => 'Delete this item?', 'message' => 'This action cannot be undone.', 'confirmLabel' => 'Delete'])

<div x-data="{ open: false }" x-on:confirmation-requested.window="open = true" x-show="open" x-cloak class="fixed inset-0 z-50 grid place-items-center bg-slate-950/80 p-4" role="dialog" aria-modal="true">
    <div x-on:click.outside="open = false" class="w-full max-w-md rounded-2xl border border-slate-700 bg-slate-900 p-6 shadow-2xl">
        <h2 class="text-lg font-bold text-white">{{ $title }}</h2>
        <p class="mt-2 text-sm leading-6 text-slate-400">{{ $message }}</p>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" x-on:click="open = false" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-300 hover:bg-slate-800">Cancel</button>
            <button type="button" x-on:click="open = false" wire:click="delete" class="rounded-lg bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-400">{{ $confirmLabel }}</button>
        </div>
    </div>
</div>
