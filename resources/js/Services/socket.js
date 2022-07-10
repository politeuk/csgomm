import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
 
window.Pusher = Pusher;

const _echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: import.meta.env.VITE_PUSHER_HOST,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    wssPort: import.meta.env.VITE_PUSHER_PORT,
    forceTLS: import.meta.env.VITE_PUSHER_SCHEME === 'http',
    encrypted: true,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});

export default function echo() {
    return _echo;
}
