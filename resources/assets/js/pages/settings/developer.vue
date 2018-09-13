<template>
  <div :title="$t('developer')">
      <h6>If you're a web developer, you'll know what these are about</h6>
    <passport-clients></passport-clients>
    <passport-personal-access-tokens></passport-personal-access-tokens>
    <small class="mt-4">The API is available at <code>{{ baseURL }}/api/v1</code> and requires a <code>Accept:application/json</code> header to return <code>JSON</code></small>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('developer') }
  },

  data: () => ({
      baseURL: window.config.apiUrl
  }),

  computed: mapGetters({
    user: 'auth/user'
  })
}
</script>
