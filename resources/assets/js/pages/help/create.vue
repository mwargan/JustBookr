<template>
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div :title="$t('register')">
                <template v-if="form.successful">
                    <div class="row">
                        <div class="col-md-7 m-auto">
                            <checkmark :active="form.successful"></checkmark>
                            <h1 class="text-center mb-3">{{ $t('you_created_a_new_business') }}</h1>
                            <div class="d-block">
                                <router-link class="btn btn-primary btn-block" to="/stand/create">Create a stand for your business</router-link>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="row">
                        <div class="col-md-7 m-auto">
                            <h1 class="text-center mb-3">{{ $t('create_your_business') }}</h1>
                        </div>
                    </div>
                    <form @submit.prevent="register" @keydown="form.onKeydown($event)">
                        <!-- Name -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('business_name') }}</label>
                            <div class="col-md-7">
                                <input v-model="form.name" type="text" placeholder="What do clients call you?" name="name" required pattern="[a-zA-Z'\s]*" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" autofocus>
                                <has-error :form="form" field="name"></has-error>
                                <small class="form-text text-muted">This is the name of your business as it is presented to customers.</small>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('description') }}</label>
                            <div class="col-md-7">
                                <textarea v-model="form.description" name="description" required class="form-control" placeholder="What is your business about?" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                                <has-error :form="form" field="description"></has-error>
                                <small class="form-text text-muted">Describe what your business is in a few words.</small>
                            </div>
                        </div>
                        <!-- Logo -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('logo') }}</label>
                            <div class="col-md-7">
                                <label class="mb-0 btn btn-white form-control" for="image">
                                    <template v-if="form.image">
                                        1 {{ $t('file_selected').toLowerCase() }}
                                    </template>
                                    <template v-else>
                                        {{ $t('upload_logo') }}
                                    </template>
                                    <input type="file" name="image" @change="selectFile" class="hidden-file" required id="image">
                                </label>
                                <has-error :form="form" field="logo"></has-error>
                                <small class="form-text text-muted">Upload your business logo to strengthen your brand. Your logo must be at least 128px by 128px, and should be a square.</small>
                            </div>
                        </div>
                        <!-- Website -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('website') }} <small>{{ $t('optional') }}</small></label>
                            <div class="col-md-7">
                                <input v-model="form.website" type="url" placeholder="https://" name="website" class="form-control" :class="{ 'is-invalid': form.errors.has('website') }">
                                <has-error :form="form" field="website"></has-error>
                                <small class="form-text text-muted">Provide a link to your business website so students can see more.</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-7 offset-md-3 d-flex">
                                <!-- Submit Button -->
                                <v-button class="btn-block" :loading="form.busy">
                                    {{ $t('create') }}
                                </v-button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-7 offset-md-3 d-flex">
                                <p>By creating this business on JustBookr you certify that you legally represent this business and you act in full accordance with the JustBookr <router-link to="/terms-and-conditions">terms and conditions</router-link>.</p>
                            </div>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import objectToFormData from 'object-to-formdata'

export default {
    metaInfo() {
        return { title: this.$t('register') }
    },

    data: () => ({
        form: new Form({
            name: '',
            description: '',
            website: '',
            logo: '',
            image: ''
        })
    }),

    methods: {
        async register() {
            //console.log('ok');
            // Register the user.
                        var v = this
            await this.form.submit('post', '/api/v1/businesses', {
                    // Transform form data to FormData
                    transformRequest: [function(data, headers) {
                        return objectToFormData(v.form)
                    }],
                    onUploadProgress: e => {
                        // Do whatever you want with the progress event
                        console.log(e)
                    }
                }).then(response => {
                console.log(response.data)
                this.user.businesses.push(response.data)
                this.$store.dispatch('auth/updateUser', { user: this.user })
            }).catch(e => {
                console.log(e)
            })
            //this.$router.push({ name: 'profile.university' })
        },
        selectFile(e) {
            const file = e.target.files[0]
            this.form.image = file
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user'
          })
    }
}
</script>
<style scoped>
    .btn.form-control {
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.5rem;
    }
    .hidden-file {
        position: absolute;
        width: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0,0,0,0);
        border: 0;
    }
</style>