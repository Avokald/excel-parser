window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'bd77f18d1088aa2c3ef5',
    cluster: 'eu',
    forceTLS: true
});

var channel = window.Echo.channel('my-channel');
channel.listen('.my-event', function (data) {
    document.querySelector('.ws-progress').innerHTML = data.message.counter;
});

let sendFileButton = document.querySelector('.send-file');
const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

if (sendFileButton) {
    sendFileButton.addEventListener('click', function (e) {
        let fileToUploadSelector = document.querySelector('.file-to-upload');

        if (!fileToUploadSelector || (typeof fileToUploadSelector.files[0] === "undefined")) {
            return;
        }

        let data = new FormData();
        data.append('file', fileToUploadSelector.files[0]);

        fetch('/process', {
            method: 'POST',
            body: data,
            headers: {
                "X-CSRF-Token": csrfToken
            },
        });
    });
}
