import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
//

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';


// Listen for the custom PostViewed event on the user's posts channel

if (typeof USER_ID !== 'undefined' && USER_ID !== null) {
    Echo.private(`recruiter.notifications.${USER_ID}`)
        .notification((notification) => {
            // alert('success');
            // Check if showToast function exists (defined in toast.blade.php)
            if (typeof showToast === 'function') {
                showToast(notification.message, notification.type || 'success');
            }
        });
}
