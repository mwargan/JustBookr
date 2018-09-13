<template>
  <div :title="$t('payment')">
    Coming soon!
  </div>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('payment') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update () {
      const { data } = await this.form.patch('/api/v1/users/'+this.user['user-id'])

      data.data.email = this.form.email

      this.$store.dispatch('auth/updateUser', { user: data.data })
    }
  }
}
</script>
