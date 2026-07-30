import LaravelEcho from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

export const Echo = new LaravelEcho({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'ap2',
    wsHost: `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'ap2'}.pusher.com`,
    wsPort: 80,
    wssPort: 443,
    forceTLS: true,
    enabledTransports: ['ws', 'wss'],
});

window.Echo = Echo;