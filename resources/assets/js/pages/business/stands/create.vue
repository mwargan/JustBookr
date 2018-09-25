<template>
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div :title="$t('register')">
                <template v-if="form.successful">
                    <div class="row">
                        <div class="col-md-7 m-auto">
                            <checkmark :active="form.successful"></checkmark>
                            <h1 class="text-center mb-3">{{ $t('you_created_a_new_stand') }}</h1>
                            <div class="d-block">
                                <router-link class="btn btn-primary btn-block" :to="'/stand/'+new_stand+'/add-books'">Post books for sale at your stand</router-link>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="row">
                        <div class="col-md-7 m-auto">
                            <h1 class="text-center mb-3">{{ $t('create_a_stand') }}</h1>
                        </div>
                    </div>
                    <form @submit.prevent="register" @keydown="form.onKeydown($event)">
                        <div class="row" v-if="user.businesses">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('your_business') }}</label>
                            <div class="col-md-7 mb-3">
                                <a href="" @click.prevent="setBusiness(business.id)" class="list-group-item list-group-item-action flex-column align-items-start" :class="{'active': form.business_id == business.id}" v-for="business in user.businesses">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">{{ business.name }}</h6>
                                        <small><fa icon="briefcase" fixed-width/></small>
                                    </div>
                                </a>
                                <has-error :form="form" field="business_id"></has-error>
                                <small class="form-text text-muted">This is the business that owns the stand, and it will show as the name on the posts.</small>
                            </div>
                        </div>
                        <!-- University -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('university_id') }}</label>
                            <div class="col-md-7">
                                <input v-model="form.uni_id" type="text" name="uni_id" placeholder="What university is the stand at?" required class="form-control" :class="{ 'is-invalid': form.errors.has('uni_id') }" autofocus>
                                <has-error :form="form" field="uni_id"></has-error>
                                <small class="form-text text-muted">Your stand should be located inside a university. You can find the university ID by looking at the info page of a university. By default, it's set to {{user.university['uni-name']}}. Example: "{{user['uni-id']}}"</small>
                            </div>
                        </div>
                        <!-- Location -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('location') }}</label>
                            <div class="col-md-7">
                                <input v-model="form.location" type="text" name="location" placeholder="Where is your stand?" required class="form-control" :class="{ 'is-invalid': form.errors.has('location') }">
                                <has-error :form="form" field="location"></has-error>
                                <small class="form-text text-muted">This will help students find your stand. Example: "In the cafeteria" or "Next to room E114"</small>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('stand_text') }}</label>
                            <div class="col-md-7">
                                <textarea v-model="form.stand_text" name="stand_text" required class="form-control" placeholder="What can you say about your stand?" :class="{ 'is-invalid': form.errors.has('stand_text') }"></textarea>
                                <has-error :form="form" field="stand_text"></has-error>
                                <small class="form-text text-muted">Your stand text will show on your posts. This is a good place to put more info and opening times. Example: "We're here on the Tuesday and Thursday of the first week of September, and we accept credit cards!"</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('payment_method') }}</label>
                            <div class="col-md-7">
                                <JbPayment @loading="loadingPayment = loadingPayment" />
                                <small class="form-text text-muted">You pay only for active stands, and you can de-activate any stand at any time.</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-7 offset-md-3 d-flex">
                                <!-- Submit Button -->
                                <v-button class="btn-block" :loading="form.busy" :disabled="!(user.stripe_id && !loadingPayment) || !form.uni_id || !form.business_id || !form.stand_text">
                                    {{ $t('create_for') }} €19.57/month
                                </v-button>
                            </div>
                            <alert-errors :form="form" class="col-md-7 offset-md-3 mt-3" message="There was an error."></alert-errors>
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
import JbPayment from '~/components/forms/inputs/Payment'

export default {
    metaInfo() {
        return { title: this.$t('register') }
    },
    components: { JbPayment },
    data: () => ({
        form: new Form({
            business_id: '',
            uni_id: '',
            location: '',
            stand_text: ''
        }),
        complete: false,
        new_stand: null,
        loadingPayment: false,
    }),
    mounted() {
        if(this.user.businesses) {
            this.form.business_id = this.user.businesses[0].id
            this.form.uni_id = this.user['uni-id']
        } else {
            this.$store.dispatch('auth/fetchUser')
            this.form.business_id = this.user.businesses[0].id
            this.form.uni_id = this.user['uni-id']
        }
    },
    methods: {
        setBusiness(id) {
            this.form.business_id = id
        },
        async register() {
            this.form.busy = true
            if (this.user.stripe_id) {
                this.form.post('/api/v1/business-stands').then(response => {
                    this.new_stand = response.data.id
                }).catch(e => {
                    if (e.response.status === 419) {
                        //location.reload()
                    }
                })
            } else {
                return false
            }

        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user'
          })
    }
}
</script>