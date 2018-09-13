<template>
    <div class="row">
        <p class="text-align-center">Redirecting...</p>
   <!--      <div class="col-lg-8 m-auto">
            <div :title="$t('register')">
                <div class="row">
                    <div class="col-md-7 offset-md-3">
                        <img src="/images/school.png" width="100%" style="max-height:200px;object-fit: scale-down;min-height: 100px;">
                        <h1 class="text-center mb-3">{{ $t('start_trading_textbooks') }}</h1>
                    </div>
                </div>
                <div class="row" v-if="facebook_app_id">
                    <div class="col-md-7 offset-md-3 text-center">
                        <a href="/login/facebook" class="btn btn-block btn-dark ml-auto" style="background: #3b5998;border-color: #3b5998;">
                {{ $t('continue_with') }} <fa fixed-width :icon="['fab', 'facebook']"/>
              </a>
                        <hr class="mt-4 mb-3" />
                    </div>
                </div>
                <form @submit.prevent="register" @keydown="form.onKeydown($event)">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right">{{ $t('full_name') }}</label>
                        <div class="col-md-7">
                            <input v-model="form.fullname" type="text" name="name" required pattern="[a-zA-Z'\s]*" class="form-control" :class="{ 'is-invalid': form.errors.hasAny('name', 'surname') }" autofocus>
                            <has-error :form="form" field="name"></has-error>
                            <has-error :form="form" field="surname"></has-error>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
                        <div class="col-md-7">
                            <input v-model="form.email" type="email" name="email" required class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
                        <div class="col-md-7">
                            <input v-model="form.password" type="password" name="password" required class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-7 offset-md-3 d-flex">

                            <v-button class="btn-block" :loading="form.busy">
                                {{ $t('sign_up') }}
                            </v-button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-7 offset-md-3 d-flex">
                            <p>By signing-up you accept the JustBookr <router-link to="/terms-and-conditions">terms and conditions</router-link>.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div> -->
    </div>
</template>
<script>
// import Form from 'vform'

export default {
    // metaInfo() {
    //     return { title: this.$t('register') }
    // },
created() {
        location.reload();
    },
    // data: () => ({
    //     form: new Form({
    //         name: '',
    //         surname: '',
    //         email: '',
    //         password: ''
    //     })
    // }),
    // computed: {
    //     facebook_app_id: () => window.config.facebook_app_id
    // },
    // methods: {
    //     async register() {
    //         var fullName = this.form.fullname.split(' ')
    //         this.form.name = fullName[0]
    //         this.form.surname = fullName[fullName.length - 1]
    //         //console.log('ok');
    //         // Register the user.
    //         const { data } = await this.form.post('/register').catch(e => {
    //             if (e.response.status === 419) {
    //                 location.reload()
    //             }
    //         })
    //         //console.log('ok2');
    //         //console.log(data);
    //         // Log in the user.
    //         const { data: { token } } = await this.form.post('/login')

    //         // Save the token.
    //         //this.$store.dispatch('auth/saveToken', { token })

    //         // Update the user.
    //         //await this.$store.dispatch('auth/updateUser', { user: data })

    //         //await this.$store.dispatch('auth/fetchUser')

    //         // Redirect home.
    //         await this.$store.dispatch('auth/fetchUser')
    //         this.$router.push({ name: 'profile.university' })
    //         //console.log('ok3');
    //     }
    // }
}
</script>