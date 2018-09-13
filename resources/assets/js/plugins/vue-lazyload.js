import Vue from 'vue'
import VueLazyload from 'vue-lazyload'

Vue.use(VueLazyload, {
  preLoad: 1.3,
  error: '/images/image_error.svg',
  loading: '/images/preloader_2.gif',
  attempt: 2
})