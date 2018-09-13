<template>
  <div :title="$t('your_info')">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('info_updated')"></alert-success>

      <!-- webometricuniversity Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('university') }}</label>
        <div class="col-md-7">
          <input v-model="form.webometricuniversity['uni-name']" type="text" name="webometricuniversity" class="form-control"
            :class="{ 'is-invalid': form.errors.has('uni-name') }">
          <input v-model="form.webometricuniversity['uni-id']" type="hidden" name="webometricuniversityId">
          <has-error :form="form" field="webometricuniversityId"></has-error>
        </div>
      </div>

      <!-- webometricuniversity ID -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('surname') }}</label>
        <div class="col-md-7">
          <input v-model="form.surname" type="text" name="surname" class="form-control"
            :class="{ 'is-invalid': form.errors.has('surname') }">
          <has-error :form="form" field="surname"></has-error>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button type="success" :loading="form.busy">{{ $t('update') }}</v-button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('webometricuniversity') }
  },

  data: () => ({
    form: new Form({
      webometricuniversity: '',
      surname: '',
      'uni-name': ''
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
      const { data } = await this.form.patch('/api/v1/me')

      this.$store.dispatch('auth/updateUser', { user: data })
    }
  }
}
</script>
