import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user']['user-id'] !== 1) {
    next({ name: 'home' })
  } else {
    next()
  }
}
