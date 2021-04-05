<template>
  <div id="app">
    <loading ref="loading" />
    <transition name="page" mode="out-in">
      <component v-if="layout" :is="layout" />
    </transition>
  </div>
</template>
<script>
import Loading from './Loading'

// Load layout components dynamically.
const requireContext = require.context('../layouts', false, /.*\.vue$/)

const layouts = requireContext.keys()
  .map(file => [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file).default])
  .reduce((components, [name, component]) => {
    components[name] = component
    return components
  }, {})

export default {
  el: '#app',

  components: {
    Loading
  },

  metaInfo() {
    const { appName } = window.config

    return {
      title: appName,
      titleTemplate: `%s · ${appName}`,
      meta: [{
        'vmid': 'og:title',
        'property': 'og:title',
        'content': 'Find Textbooks',
        'template': chunk => `${chunk} · ${appName}` //or as string template: '%s - My page'
      }]
    }
  },

  data: () => ({
    layout: null,
    defaultLayout: 'app'
  }),

  mounted() {
    this.$loading = this.$refs.loading
  },

  methods: {
    /**
     * Set the application layout.
     *
     * @param {String} layout
     */
    setLayout(layout) {
      if (!layout || !layouts[layout]) {
        layout = this.defaultLayout
      }

      this.layout = layouts[layout]
    }
  }
}

</script>
