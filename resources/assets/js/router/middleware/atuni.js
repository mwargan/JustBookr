import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user']['uni-id'] === null) {
    next({ name: 'profile.university' })
  } else {
    next()
  }
}
