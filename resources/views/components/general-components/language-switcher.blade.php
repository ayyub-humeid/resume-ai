<div class="relative inline-block text-left" id="language-switcher-container">
    <div>
        <button onclick="toggleLanguageMenu()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" aria-expanded="true">
            {{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}
            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <div id="language-dropdown-menu" class="hidden origin-top-right absolute {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">English</a>
            <a href="{{ route('lang.switch', 'ar') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">العربية</a>
        </div>
    </div>
</div>

<script>
    function toggleLanguageMenu() {
        const menu = document.getElementById('language-dropdown-menu');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
        }
    }

    // Close the dropdown if the user clicks outside of it
    window.addEventListener('click', function(e) {
        const container = document.getElementById('language-switcher-container');
        const menu = document.getElementById('language-dropdown-menu');
        if (!container.contains(e.target)) {
            if (!menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        }
    });
</script>
