import Vue from 'vue'
import { HasError, AlertError, AlertErrors, AlertSuccess } from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)

Vue.component(
    'PassportClients',
    require('./passport/Clients.vue').default
);

Vue.component(
    'PassportAuthorizedClients',
    require('./passport/AuthorizedClients.vue').default
);

Vue.component(
    'PassportPersonalAccessTokens',
    require('./passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'FeedOtherEditions',
    require('./feeds/OtherEditions.vue').default
);

// Load global components dynamically
// const requireContext = require.context('./global', true, /.*\.(js|vue)$/)
// requireContext.keys().forEach(file => {
//   const Component = requireContext(file)

//   if (Component.name) {
//     Vue.component(Component.name, Component.default)
//   }
// })

const files = require.context('./global', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
