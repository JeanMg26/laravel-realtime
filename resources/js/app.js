require('./bootstrap');

import Echo from "laravel-echo"

Echo.private('notifications')
   .listen('UserSessionChanged', (e) => {
      const notifelement = document.getElementById('notification');

      notifelement.innerText = e.message;

      notifelement.classList.remove('invisible');
      notifelement.classList.remove('alert-success');
      notifelement.classList.remove('alert-danger');

      notifelement.classList.add('alert-' + e.type);
   })
