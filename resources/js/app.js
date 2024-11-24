import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'your-pusher-key',
    cluster: 'eu',
    forceTLS: true,
});

Echo.private('notifications.' + userId) 
    .listen('NewNotification', (e) => {
        console.log('Notification received:', e);
        alert(e.message);
});