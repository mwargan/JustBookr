import store from '~/store'
//import Router from 'vue-router'

export default async (to, from, next) => {
  if (!store.getters['auth/check']) {
    next({ name: 'login', query: { redirect: to.path } })
  } else if (store.getters['auth/check'] && !store.getters['auth/user']['uni-id']) {
    next({ name: 'profile.university', query: { redirect: to.path } })
  } else {
    next()
  }
}
