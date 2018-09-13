<template>
    <div>
        <a class="list-group-item list-group-item-action flex-column align-items-start disabled" v-if="cash && !update">
            <div class="d-flex w-100 justify-content-between align-items-center">
                <h6 class="mb-0">{{ $t('cash_payment') }}</h6>
                <small><fa icon="money-bill" fixed-width/></small>
            </div>
        </a>
        <a class="list-group-item list-group-item-action flex-column align-items-start disabled" v-else-if="user.stripe_id && !update" @click="update = true">
            <div class="d-flex w-100 justify-content-between align-items-center" style="cursor:pointer;">
                <h6 class="mb-0">{{ $t('card_payment') }}</h6>
                <small><fa :icon="['fab', 'cc-'+user.card_brand.toLowerCase()]" fixed-width/> **** {{ user.card_last_four }}
                </small>
            </div>
        </a>
        <a class="list-group-item list-group-item-action flex-column align-items-start disabled" v-else>
            <p class="mb-0" v-if="loading" >Updating your card</p>
            <card v-show="!loading" class='stripe-card' :disabled="loading" :class='{ complete }' :stripe='stripe_key' @change='complete = $event.complete' />
            <button v-if="user.stripe_id" type="button" class="close" aria-label="Close" @click.prevent="update = false" style="top: -0.3rem;right: 0.2rem;color: #7d7d7d;position: absolute;">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="invalid-feedback d-block" v-if="errors.error">{{errors.error}}</div>
        </a>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    props: ['input'],
    components: { Card },
    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
        stripe_key: () => window.config.stripe_key
    },
    watch: {
        'complete': function(id) {
            console.log(id)
            if (this.complete) {
                this.setCard()
            } else {
                this.errors = {}
            }
        },
        'loading': function(id) {
            console.log(id)
            this.$emit('loading', id)
        }
    },
    data: () => ({
        complete: false,
        loading: false,
        update: false,
        errors: {}
    }),

    mounted() {},

    methods: {
        setCard() {
            this.loading = true
            createToken().then(data => {
                axios.post('/api/v1/me/card', {
                    card_token: data.token.id,
                }).then(response => {
                    response.data.email = this.user.email
                    this.$store.dispatch('auth/updateUser', { user: response.data })
                    this.loading = false
                    this.update = false
                }).catch(e => {
                    console.log(e.response.data)
                    this.errors = e.response.data.errors
                    this.loading = false
                    console.log(this.errors)
                })
            })
        }
    }
}
</script>
<style scoped>
</style>