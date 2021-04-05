import Vue from 'vue'
import router from '~/router'
import VueAnalytics from 'vue-analytics'

const isProd = process.env.NODE_ENV === 'production'

Vue.use(VueAnalytics, {
	id: 'UA-76122959-2',
	router,
	debug: {
		enabled: !isProd,
		sendHitTask: isProd
	},
	ecommerce: {
		enabled: true
	}
})
