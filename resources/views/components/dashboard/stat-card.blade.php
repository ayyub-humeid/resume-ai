@props(['label', 'value', 'tone' => 'blue'])

<div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
    <p class="text-sm font-medium text-slate-400">{{ $label }}</p>
    <p @class([
        'mt-2 text-3xl font-bold',
        'text-blue-300' => $tone === 'blue',
        'text-indigo-300' => $tone === 'indigo',
        'text-emerald-300' => $tone === 'emerald',
    ])>{{ $value }}</p>
</div>
