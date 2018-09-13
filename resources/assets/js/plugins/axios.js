import axios from 'axios'
import store from '~/store'
import router from '~/router'
import swal from 'sweetalert2'
import { i18n } from '~/plugins/i18n'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window._token = token.content;
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
// Request interceptor
axios.interceptors.request.use(request => {
  const token = store.getters['auth/token']
  if (token) {
    //request.headers.common['Authorization'] = `Bearer ${token}`
  }
  const locale = store.getters['lang/locale']
  if (locale) {
    axios.defaults.headers.common['Accept-Language'] = locale
  }
  // request.headers['X-Socket-Id'] = Echo.socketId()

  return request
})

// Response interceptor
axios.interceptors.response.use(response => response, error => {
  const { status } = error.response

  if (status >= 500) {
    swal({
      type: 'error',
      title: i18n.t('error_alert_title'),
      text: i18n.t('error_alert_text'),
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel')
    })
  }

  if (status === 403) {
    swal({
      type: 'error',
      title: 'You don\t have permission to do this!',
      text: 'You don\t have sufficient rights to perform this action. If you are posting a book for sale, this usually means that you already posted the same book before (you can only post one copy of each book unless you sign up as a business).',
      reverseButtons: true,
      confirmButtonText: i18n.t('ok')
    })
  }

  if (status === 429) {
    swal({
      type: 'error',
      title: 'Slow down!',
      text: 'We put your account on hold for a couple of minutes because we detected some fishy activity.',
      reverseButtons: true,
      confirmButtonText: i18n.t('ok')
    })
  }

  if (status === 401 && store.getters['auth/check']) {
    swal({
      type: 'warning',
      title: i18n.t('token_expired_alert_title'),
      text: i18n.t('token_expired_alert_text'),
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel')
    })
    .then(async () => {
      await store.dispatch('auth/logout')
      location.reload()
      //router.push({ name: 'login' })
    })
  }

  return Promise.reject(error)
})
