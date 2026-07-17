<!-- Toast Container -->
<div id="toast-container"
    class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 max-w-sm w-full px-4 sm:px-0 pointer-events-none">
    <!-- Dynamic toasts will render here -->
</div>

<script>
    /**
     * Show a modern Tailwind-styled toast notification.
     * @param {string} message The message to display.
     * @param {string} type The toast type: 'success', 'error', 'info', 'warning'.
     */
    window.showToast = function (message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        // Create the toast wrapper element
        const toast = document.createElement('div');
        toast.className =
            `pointer-events-auto relative overflow-hidden flex items-start gap-3 p-4 rounded-xl shadow-xl border bg-white/95 backdrop-blur-md border-slate-100 transition-all duration-300 ease-out transform translate-x-full opacity-0 w-full`;

        let icon = 'check_circle';
        let iconColor = 'text-emerald-500 bg-emerald-50';
        let progressColor = 'bg-emerald-500';

        if (type === 'error') {
            icon = 'error';
            iconColor = 'text-rose-500 bg-rose-50';
            progressColor = 'bg-rose-500';
        } else if (type === 'warning') {
            icon = 'warning';
            iconColor = 'text-amber-500 bg-amber-50';
            progressColor = 'bg-amber-500';
        } else if (type === 'info') {
            icon = 'info';
            iconColor = 'text-blue-500 bg-blue-50';
            progressColor = 'bg-blue-500';
        }

        toast.innerHTML = `
            <div class="flex-shrink-0 p-1.5 rounded-lg ${iconColor} flex items-center justify-center">
                <span class="material-symbols-outlined text-[20px] font-bold">${icon}</span>
            </div>
            <div class="flex-grow pt-0.5">
                <p class="text-sm font-semibold text-slate-800 leading-tight">${message}</p>
            </div>
            <button class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition-all p-1 rounded-lg hover:bg-slate-100" onclick="dismissToast(this.parentElement)">
                <span class="material-symbols-outlined text-[16px]">close</span>
            </button>
            <!-- Progress Bar Tracker -->
            <div class="absolute bottom-0 left-0 h-[3px] ${progressColor} w-full transition-all ease-linear" style="transition-duration: 4000ms; width: 100%;"></div>
        `;

        // Add to DOM
        container.appendChild(toast);

        // Slide in
        setTimeout(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
        }, 120);

        // Animate the progress bar shrinking
        const progressBar = toast.querySelector('.absolute.bottom-0');
        setTimeout(() => {
            progressBar.style.width = '0%';
        }, 50);

        // Self-dismiss timer (4 seconds)
        const autoDismissTimer = setTimeout(() => {
            dismissToast(toast);
        }, 40000);

        // Store timer to prevent memory leak/errors on manual close
        toast.dataset.timerId = autoDismissTimer;
    }

    /**
     * Dismiss a specific toast notification with animation.
     * @param {HTMLElement} toastElement
     */
    window.dismissToast = function (toastElement) {
        if (!toastElement) return;

        // Clear active timer if dismissed early manually
        if (toastElement.dataset.timerId) {
            clearTimeout(parseInt(toastElement.dataset.timerId));
        }

        toastElement.classList.add('translate-x-full', 'opacity-0');

        // Wait for animation, then remove
        setTimeout(() => {
            toastElement.remove();
        }, 300);
    }

    // Livewire listener for toasts
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('toast', (data) => {
            let msg = '';
            let type = 'success';
            if (Array.isArray(data) && data.length > 0) {
                if (typeof data[0] === 'object') {
                    msg = data[0].message || '';
                    type = data[0].type || 'success';
                } else {
                    msg = data[0];
                }
            } else if (typeof data === 'object') {
                msg = data.message || '';
                type = data.type || 'success';
            }
            if (msg) showToast(msg, type);
        });
    });
</script>

<!-- Session message handlers for Laravel redirects -->
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast("{{ session('success') }}", 'success');
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast("{{ session('error') }}", 'error');
        });
    </script>
@endif

@if (session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast("{{ session('warning') }}", 'warning');
        });
    </script>
@endif

@if (session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast("{{ session('info') }}", 'info');
        });
    </script>
@endif