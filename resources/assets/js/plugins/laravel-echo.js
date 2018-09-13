import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
	broadcaster: 'pusher',
	key: '9f02ac182db33c029b8f',
	cluster: 'eu',
	encrypted: true
});