<template>
    <div>
        <div class="modal fade" tabindex="-1" role="dialog" id="boostModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $t('boost_your_post') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" role="form" @submit.prevent="boostPost" @keydown="form.onKeydown($event)" v-if="post">
                        <div class="modal-body">
                            <!-- Price -->
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <img class="responsive" src="/images/icons/custom/business/posts.svg" style="max-height: 150px;">
                                </div>
                                <div class="col-md-7 align-self-center">
                                    <p>Boost your post to increase your chances of selling your book. Your post will be pinned to the top and seen on more pages, by even more people.</p>
                                </div>
                            </div>
                            <!-- Price -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right" for="price">{{ $t('boost_time') }}</label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input v-model="form.expires_at" type="number" pattern="[0-9]*" name="price" class="form-control" :class="{ 'is-invalid': form.errors.has('expires_at') }" maxlength="3" minlength="1" required min="2" max="182" data-hj-whitelist>
                                        <div class="input-group-append">
                                            <span class="input-group-text">days</span>
                                        </div>
                                    </div>
                                    <has-error :form="form" field="expires_at"></has-error>
                                    <small class="form-text text-muted">This is how long your post will be boosted for.</small>
                                </div>
                            </div>
                            <!-- Payment -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right" for="price">{{ $t('payment_method') }}</label>
                                <div class=" col-md-7">
                                    <JbPayment @loading="setPaymentLoading" />
                                    <has-error :form="form" field="price"></has-error>
                                    <small class="form-text text-muted">You are charged upfront for the duration of your boost.</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <router-link to="/faq" class="btn mr-auto text-secondary" data-dismiss="modal" aria-label="Close">{{ $t('help') }}</router-link>
                            <v-button @click="boostPost" :loading="form.busy" :disabled="payment_loading || !this.user || !this.user.stripe_id">
                                {{ $t('boost_for') }} {{price}}
                            </v-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import JbPayment from '~/components/forms/inputs/Payment'
import axios from 'axios'

import Form from 'vform'
import swal from 'sweetalert2'

import { mapGetters } from 'vuex'

export default {
    props: ['post'],

    components: { JbPayment },

    name: 'boost-modal',
    data: () => ({
        complete: false,
        payment_loading: false,
        form: new Form({
            expires_at: 9,
            post_id: 0
        }),

    }),
    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
        isBoosted() {
            return (this.form.isbn.length === 13 && this.form['post-description'].length >= 10 && this.form.price > 0) ? false : true

        },
        totalValue() {
            if (!this.post || !this.post.price) {
                return false;
            }
            let post_price = this.post.price.match(/\d/g).join("");
            let post_value = 0;
            if (this.post && post_price) {
                post_value = Math.log(post_price) / 13;
            }
            let final_price = (post_value * this.form.expires_at) + 1.3;
            if (final_price < post_price) {
                return Math.round(final_price)
            } else {
                return Math.round(post_price)
            }
        },
        price() {
            return "€" + this.totalValue
        }
    },
    methods: {
        setPaymentLoading(value) {
            this.payment_loading = value
        },
        boostPost() {

            this.form.post_id = this.post['post-id']
            if (this.user && this.user.stripe_id) {
                this.form.post('/api/v1/post-boosts').then(response => {
                    this.complete = true
                    this.$emit('postPromoted', response.data)
                    $('#boostModal').modal('hide')
                    scroll(0, 250)
                let texts = [this.$t('nice'), this.$t('awesome'), this.$t('high_five'), this.$t('cool'), this.$t('great_job'), this.$t('nicely_done')]

                let label_text = texts[Math.floor(Math.random() * texts.length)]+"!"
                    swal({
                        toast: true,
                        title: this.$t(label_text),
                        text: `${this.$t('you_boosted_your_post')}.`,
                        type: 'success',
                        position: 'top-end',
                        timer: 0
                    })
                }).catch(e => {
                    console.log(e)
                     swal(
                        this.$t(this.$t('something_went_wrong'))
                    )
                })
            } else {
                return false
            }
        }
    }
}
</script>