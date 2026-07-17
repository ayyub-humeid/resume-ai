import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import { Echo } from './echo';
//

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */




// Listen for the custom PostViewed event on the user's posts channel

if (typeof USER_ID !== 'undefined' && USER_ID !== null) {
    window.Echo.private(`recruiter.notifications.${USER_ID}`)
        .notification((notification) => {
            
            // Show real-time toast
            if (typeof window.showToast === 'function') {
                window.showToast(notification.message, notification.type || 'success');
            }

            // Increment the unread badge count automatically
            const badge = document.getElementById('notifications-count');
            if (badge) {
                let currentCount = parseInt(badge.innerText) || 0;
                badge.innerText = currentCount + 1;
                badge.classList.remove('hidden');
            }

            // Dynamically inject the new notification into the dropdown list
            const list = document.getElementById('notification-list');
            if (list) {
                // Remove the empty state message if it exists
                const emptyState = document.getElementById('empty-notifications');
                if (emptyState) emptyState.remove();

                const icon = notification.type === 'success' ? 'task_alt' : 'notifications';
                const link = notification.link ? notification.link : '#';
                
                const notifHtml = `
                    <div class="relative flex gap-3 border-b border-slate-800/50 p-4 transition-colors hover:bg-slate-800/50 bg-slate-800/20 animate-in fade-in slide-in-from-top-2 duration-300">
                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-500/20 text-blue-400">
                            <span class="material-symbols-outlined text-[16px]">${icon}</span>
                        </div>
                        <div class="flex-1">
                            <a href="${link}" class="block focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-semibold text-slate-200">${notification.title || 'New Notification'}</p>
                                <p class="mt-1 text-xs text-slate-400 leading-relaxed">${notification.body || notification.message}</p>
                                <p class="mt-2 text-[10px] font-medium text-slate-500">Just now</p>
                            </a>
                        </div>
                        <div class="absolute right-4 top-4 h-2 w-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.8)]"></div>
                    </div>
                `;
                
                list.insertAdjacentHTML('afterbegin', notifHtml);
            }
        });
}
