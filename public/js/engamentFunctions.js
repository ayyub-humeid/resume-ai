function clickMe() {
    alert('cl');
}
function pushNotification(data) {
    alert('Hi');
    // 1. Increment the notification count in the nav
    const badge = document.getElementById('notification-badge');
    if (badge) {
        let currentCount = parseInt(badge.textContent) || 0;
        badge.textContent = currentCount + 1;
        badge.classList.remove('hidden');
    }

    // 2. Create the notification toast
    const container = document.getElementById('toast-container');
    if (!container) return;

    const notification = document.createElement('div');
    notification.className = `pointer-events-auto relative overflow-hidden flex items-start gap-4 p-4 rounded-2xl shadow-2xl border bg-white/95 backdrop-blur-xl border-slate-200 transition-all duration-500 ease-out transform translate-x-full opacity-0 w-full max-w-sm hover:scale-[1.02] cursor-pointer`;

    // Add link functionality if link is provided
    if (data.link) {
        notification.onclick = (e) => {
            if (!e.target.closest('button')) {
                window.location.href = data.link;
            }
        };
    }

    const avatar = data.meta && data.meta.follower_avatar
        ? `<img src="${data.meta.follower_avatar}" class="w-12 h-12 rounded-full object-cover border-2 border-primary/20" alt="Avatar">`
        : `<div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xl border-2 border-primary/20">
            <span class="material-symbols-outlined">notifications</span>
           </div>`;

    notification.innerHTML = `
        <div class="flex-shrink-0 animate-pulse">
            ${avatar}
        </div>
        <div class="flex-grow pt-0.5">
            <h4 class="text-sm font-bold text-slate-900 leading-tight mb-1">${data.title || 'New Notification'}</h4>
            <p class="text-xs font-medium text-slate-600 leading-snug">${data.body || 'You have a new update.'}</p>
            <div class="mt-2 flex items-center gap-2">
                <span class="text-[10px] font-bold uppercase tracking-wider text-primary bg-primary/10 px-2 py-0.5 rounded-full">Real-time</span>
                <span class="text-[10px] text-slate-400 font-medium">Just now</span>
            </div>
        </div>
        <button class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition-all p-1.5 rounded-xl hover:bg-slate-100 group" onclick="this.closest('.pointer-events-auto').remove()">
            <span class="material-symbols-outlined text-[18px] group-hover:rotate-90 transition-transform duration-300">close</span>
        </button>
        <div class="absolute bottom-0 left-0 h-[4px] bg-gradient-to-r from-primary to-purple-500 w-full transition-all ease-linear" id="progress-bar-${Date.now()}" style="width: 100%;"></div>
    `;

    container.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full', 'opacity-0');
    }, 10);

    // Progress bar animation
    const progressBar = notification.querySelector('[id^="progress-bar-"]');
    setTimeout(() => {
        progressBar.style.transition = 'width 6000ms linear';
        progressBar.style.width = '0%';
    }, 50);

    // Auto dismiss
    setTimeout(() => {
        if (notification.parentNode) {
            notification.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => notification.remove(), 500);
        }
    }, 12000);
}