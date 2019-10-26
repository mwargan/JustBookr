<template>
    <div>
        <div class="modal fade" tabindex="-1" role="dialog" id="imageModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $t('boost_your_post') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Price -->
                        <div class="row">
                            <div class="col-md-12">
                                <img class="responsive" src="/images/icons/custom/business/posts.svg" style="max-height: 150px;">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <router-link to="/faq" class="btn mr-auto text-secondary">{{ $t('help') }}</router-link>
                            <v-button @click="boostPost" :loading="form.busy" :disabled="payment_loading || !this.user || !this.user.stripe_id">
                                {{ $t('boost_for') }} {{price}}
                            </v-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
import axios from 'axios'

import Form from 'vform'
import swal from 'sweetalert2'

import { mapGetters } from 'vuex'

export default {
    props: ['post'],


    name: 'image-modal',
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

        boostPost() {

            this.form.post_id = this.post['post-id']
            if (this.user && this.user.stripe_id) {
                this.form.post('/api/v1/post-boosts').then(response => {
                    this.complete = true
                    this.$emit('postPromoted', response.data)
                    $('#boostModal').modal('hide')
                    scroll(0, 250)
                    let texts = [this.$t('nice'), this.$t('awesome'), this.$t('high_five'), this.$t('cool'), this.$t('great_job'), this.$t('nicely_done')]

                    let label_text = texts[Math.floor(Math.random() * texts.length)] + "!"
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