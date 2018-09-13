<template>
     <div class="row">
        <p class="text-align-center">Redirecting...</p>
<!--        <div class="col-lg-8 m-auto">
            <div :title="$t('login')">
                <div class="row">
                    <div class="col-md-7 offset-md-3">
                        <img src="/images/bookshelf.svg" width="100%" style="max-height:200px;min-height: 100px;">
                        <h1 class="text-center mb-3">{{ $t('log_in_to_justbookr') }}</h1>
                    </div>
                </div>
                <form @submit.prevent="login" @keydown="form.onKeydown($event)">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
                        <div class="col-md-7">
                            <input v-model="form.email" type="email" name="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" required>
                            <has-error :form="form" field="email"></has-error>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
                        <div class="col-md-7">
                            <input v-model="form.password" type="password" name="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" required>
                            <has-error :form="form" field="password"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-7 offset-md-3 d-flex">

                            <v-button class="btn-block" :loading="form.busy">
                                {{ $t('login') }}
                            </v-button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-7">
                            <router-link :to="{ name: 'password.request' }" class="float-right small">
                                {{ $t('forgot_password') }}
                            </router-link>
                            <a v-if="facebook_app_id" href="/login/facebook" class="btn btn-dark ml-auto" style="background: #3b5998;border-color: #3b5998;">
                {{ $t('continue_with') }} <fa fixed-width :icon="['fab', 'facebook']"/>
              </a>
                            <p v-else class="text-muted mt-5">We are currently experienceing issues with Facebook login. If you've logged in with Facebook before, go to
                                <router-link :to="{ name: 'password.request' }">this link</router-link> and type in the email you used to sign up to Facebook, the one we sent you a welcome email on.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div> -->
    </div>
</template>
<script>
// import Form from 'vform'
//import { mapGetters } from 'vuex'

export default {
    metaInfo() {
        return { title: this.$t('login') }
    },

    // data: () => ({
    //     form: new Form({
    //         email: '',
    //         password: ''
    //     }),
    //     remember: true
    // }),
    created() {
        location.reload();
    },
    // methods: {
    //     async login() {
    //         // Submit the form.
    //         const { data } = await this.form.post('/login').catch(e => {
    //             if (e.response.status == 419 || e.response.status == 302) {
    //                 console.log(e)
    //                 console.log(e.response)
    //                 location.reload()
    //             }
    //             return false
    //         })
    //         if (data) {
    //             location.reload()
    //             await this.$store.dispatch('auth/fetchUser')
    //             // Redirect home.
    //             this.$router.push(this.$route.query.redirect || '/discover')
    //         }
    //         // Save the token.
    //         // this.$store.dispatch('auth/saveToken', {
    //         //     token: data.token,
    //         //     remember: this.remember
    //         // })
    //     },
    //     async loginWithFacebook() {
    //         // Submit the form.
    //         const { data } = await this.form.get('/login/facebook')
    //         // // Save the token.
    //         // this.$store.dispatch('auth/saveToken', {
    //         //     token: data.token,
    //         //     remember: this.remember
    //         // })

    //         // Fetch the user.
    //         await this.$store.dispatch('auth/fetchUser')
    //         // Redirect home.
    //         this.$router.push(this.$route.query.redirect || '/discover')
    //     }
    // },
    // computed: {
    //     facebook_app_id: () => window.config.facebook_app_id
    // }
}
</script>