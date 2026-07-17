<!-- Confirmation Modal Container -->
<div id="confirmation-modal-container"
    class="fixed inset-0 z-[10000] flex items-center justify-center bg-slate-950/80 p-4 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none">
    
    <div id="confirmation-modal-content"
        class="w-full max-w-sm scale-95 transform rounded-2xl border border-slate-800 bg-slate-900 p-6 shadow-2xl transition-all duration-300">
        
        <div class="flex items-start gap-4">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-500/20 text-red-400">
                <span class="material-symbols-outlined">warning</span>
            </div>
            <div class="pt-1">
                <h3 id="confirmation-modal-title" class="text-lg font-bold text-white">Confirm Action</h3>
                <p id="confirmation-modal-message" class="mt-2 text-sm leading-relaxed text-slate-400">Are you sure you want to do this?</p>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <button type="button" onclick="window.closeConfirmationModal()"
                class="rounded-xl border border-slate-700 bg-transparent px-4 py-2.5 text-sm font-semibold text-slate-300 transition-colors hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-900">
                Cancel
            </button>
            <button type="button" id="confirmation-modal-confirm-btn"
                class="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 focus:ring-offset-slate-900">
                Confirm
            </button>
        </div>
    </div>
</div>

<script>
    window.activeConfirmationCallback = null;

    /**
     * Show a custom Tailwind confirmation modal.
     * @param {string} message The confirmation message
     * @param {function} callback The function to execute on confirm
     * @param {string} title The title of the modal
     */
    window.confirmAction = function(message, callback, title = 'Confirm Action') {
        const container = document.getElementById('confirmation-modal-container');
        const content = document.getElementById('confirmation-modal-content');
        const titleEl = document.getElementById('confirmation-modal-title');
        const messageEl = document.getElementById('confirmation-modal-message');
        const confirmBtn = document.getElementById('confirmation-modal-confirm-btn');

        if (!container) return;

        titleEl.textContent = title;
        messageEl.textContent = message;

        // Store callback
        window.activeConfirmationCallback = callback;

        // Show modal
        container.classList.remove('opacity-0', 'pointer-events-none');
        container.classList.add('opacity-100');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');

        // Setup confirm button
        confirmBtn.onclick = function() {
            if (window.activeConfirmationCallback) {
                window.activeConfirmationCallback();
            }
            window.closeConfirmationModal();
        };
    };

    window.closeConfirmationModal = function() {
        const container = document.getElementById('confirmation-modal-container');
        const content = document.getElementById('confirmation-modal-content');
        
        if (!container) return;

        container.classList.remove('opacity-100');
        container.classList.add('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        
        window.activeConfirmationCallback = null;
    };
</script>
