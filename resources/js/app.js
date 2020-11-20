require('./bootstrap');

Echo.private('notifications')
    .listen('UserChangeEvent', (e) =>{
        const notificationElement = document.getElementById('notifications');
        notificationElement.innerText = e.message;
        notificationElement.classList.remove('invisible');
        notificationElement.classList.remove('alert-success');
        notificationElement.classList.remove('alert-danger');

        notificationElement.classList.add('alert-'+ e.type);
    });
