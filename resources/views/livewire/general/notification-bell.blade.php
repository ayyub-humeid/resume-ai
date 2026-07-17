<div class="relative" id="notification-container">
    <button onclick="toggleNotifications()" type="button" class="relative rounded-full bg-slate-800/80 p-2 text-slate-400 hover:bg-slate-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-200">
        <span class="sr-only">{{ __('View notifications') }}</span>
        <span class="material-symbols-outlined text-[20px]">notifications</span>
        
        @php
            $unreadCount = auth()->user()->unreadNotifications->count();
        @endphp
        <div wire:ignore.self id="notifications-count" class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.8)] text-[9px] font-bold text-white {{ $unreadCount === 0 ? 'hidden' : '' }}">
            {{ $unreadCount }}
        </div>
    </button>

    <!-- Dropdown menu -->
    <div id="notification-dropdown" class="hidden absolute right-0 z-50 mt-3 w-80 sm:w-96 origin-top-right rounded-2xl bg-slate-900 border border-slate-700 shadow-2xl shadow-black/50 focus:outline-none overflow-hidden">
         
        <div class="flex items-center justify-between border-b border-slate-800 bg-slate-900 px-5 py-4">
            <h3 class="text-sm font-bold text-white">{{ __('Notifications') }}</h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs font-semibold text-blue-400 hover:text-blue-300 transition-colors">{{ __('Mark all as read') }}</button>
            @endif
        </div>

        <div id="notification-list" class="max-h-[26rem] overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="relative flex gap-3 border-b border-slate-800/50 p-4 transition-colors hover:bg-slate-800/50 {{ is_null($notification->read_at) ? 'bg-slate-800/20' : 'opacity-70' }}">
                    
                    <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-500/20 text-blue-400">
                        <span class="material-symbols-outlined text-[16px]">{{ $notification->data['type'] === 'success' ? 'task_alt' : 'notifications' }}</span>
                    </div>

                    <div class="flex-1">
                        @if(isset($notification->data['link']))
                            <a href="{{ $notification->data['link'] }}" wire:click="markAsRead('{{ $notification->id }}')" class="block focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-semibold text-slate-200">{{ $notification->data['title'] ?? __('Notification') }}</p>
                                <p class="mt-1 text-xs text-slate-400 leading-relaxed">{{ $notification->data['body'] ?? $notification->data['message'] ?? '' }}</p>
                                <p class="mt-2 text-[10px] font-medium text-slate-500">{{ $notification->created_at->diffForHumans() }}</p>
                            </a>
                        @else
                            <div wire:click="markAsRead('{{ $notification->id }}')" class="cursor-pointer">
                                <p class="text-sm font-semibold text-slate-200">{{ $notification->data['title'] ?? __('Notification') }}</p>
                                <p class="mt-1 text-xs text-slate-400 leading-relaxed">{{ $notification->data['body'] ?? $notification->data['message'] ?? '' }}</p>
                                <p class="mt-2 text-[10px] font-medium text-slate-500">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>
                    
                    @if(is_null($notification->read_at))
                        <div class="absolute right-4 top-4 h-2 w-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.8)]"></div>
                    @endif
                </div>
            @empty
                <div id="empty-notifications" class="flex flex-col items-center justify-center py-10 px-4 text-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-800 text-slate-500 mb-3">
                        <span class="material-symbols-outlined">notifications_off</span>
                    </div>
                    <p class="text-sm font-medium text-slate-300">{{ __('No notifications yet') }}</p>
                    <p class="mt-1 text-xs text-slate-500">{{ __("We'll notify you when your rankings are complete.") }}</p>
                </div>
            @endforelse
        </div>
        
        <div class="border-t border-slate-800 bg-slate-900/50 px-5 py-3 text-center">
            <a href="#" class="text-xs font-semibold text-slate-400 hover:text-white transition-colors">{{ __('View all activity') }}</a>
        </div>
    </div>
</div>

<script>
    function toggleNotifications() {
        const dropdown = document.getElementById('notification-dropdown');
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            dropdown.classList.add('animate-in', 'fade-in', 'zoom-in-95', 'duration-200');
        } else {
            dropdown.classList.add('hidden');
            dropdown.classList.remove('animate-in', 'fade-in', 'zoom-in-95', 'duration-200');
        }
    }

    document.addEventListener('click', function(event) {
        const container = document.getElementById('notification-container');
        const dropdown = document.getElementById('notification-dropdown');
        
        if (container && !container.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
