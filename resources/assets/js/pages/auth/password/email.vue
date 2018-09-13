<template>
    <div>
        <div class="row">
            <div class="col-lg-8 offset-md-2">
                <h1 class="text-center mb-3">{{ $t('reset_your_password') }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div :title="$t('reset_password')">
                    <form @submit.prevent="send" @keydown="form.onKeydown($event)">
                        <alert-success :form="form" :message="$t('password_reset_email_sent')"></alert-success>
                        <!-- Email -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
                            <div class="col-md-7">
                                <input v-model="form.email" type="email" name="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" required>
                                <has-error :form="form" field="email"></has-error>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="form-group row">
                            <div class="col-md-9 ml-md-auto">
                                <v-button :loading="form.busy">{{ $t('send_password_reset_link') }}</v-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Form from 'vform'

export default {
    metaInfo() {
        return { title: this.$t('reset_password') }
    },

    data: () => ({
        status: '',
        form: new Form({
            email: ''
        })
    }),

    methods: {
        async send() {
            const { data } = await this.form.post('/password/email')

            this.status = data.status

            this.form.reset()
        }
    }
}
</script>