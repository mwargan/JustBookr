import Vue from 'vue'
import { HasError, AlertError, AlertErrors, AlertSuccess } from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)

Vue.component(
    'passport-clients',
    require('./passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./passport/PersonalAccessTokens.vue')
);

Vue.component(
    'feed-other-editions',
    require('./feeds/OtherEditions.vue')
);

// Load global components dynamically
const requireContext = require.context('./global', true, /.*\.(js|vue)$/)
requireContext.keys().forEach(file => {
  const Component = requireContext(file)

  if (Component.name) {
    Vue.component(Component.name, Component)
  }
})
