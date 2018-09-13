<template>
  <div :title="$t('authorized_applications')">
    <h6>Applications that you allow to use your JustBookr info will show here</h6>
    <passport-authorized-clients></passport-authorized-clients>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('authorized_applications') }
  },

  data: () => ({

  }),

  computed: mapGetters({
    user: 'auth/user'
  })
}
</script>
