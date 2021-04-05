<template>
    <div>
        <div class="modal fade" id="modal-edit-order" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $t('edit_order') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Edit Client Form -->
                    <form class="form-horizontal" role="form" @submit.prevent="updateOrder" @keydown="form.onKeydown($event)" v-if="order">
                        <div class="modal-body">
                            <!-- Name -->
                            <div class="form-group row">
                                <label for="location-meet" class="col-md-3 col-form-label text-md-right">{{ $t('where') }}?</label>
                                <div class="col-md-7">
                                    <select v-model="form['location-meet']" name="location-meet" class="form-control" :class="{ 'is-invalid': form.errors.has('location-meet') }" :placeholder="$t('example')+': '+$t('at_the_library')" required autofocus data-hj-whitelist>
                                        <option>{{ $t('at_the_cafeteria') }}</option>
                                        <option>{{ $t('at_the_library') }}</option>
                                        <option>{{ $t('by_the_main_entrance') }}</option>
                                        <option>{{ $t('in_class') }}</option>
                                    </select>
                                    <has-error :form="form" field="location-meet"></has-error>
                                    <small class="form-text text-muted">Choose where you want to meet at the university to get your new book.</small>
                                </div>
                            </div>
                            <!-- When -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">{{ $t('when') }}?</label>
                                <div class="col-md-7">
                                    <input v-model="date" type="datetime-local" name="location-date" class="form-control" :class="{ 'is-invalid': form.errors.has('location-date') }" required placeholder="DD/MM/YYYY HH:MM" :min="$moment().format($moment.HTML5_FMT.DATETIME_LOCAL)" :max="$moment().add(1, 'M').format($moment.HTML5_FMT.DATETIME_LOCAL)" data-hj-whitelist>
                                    <has-error :form="form" field="location-date"></has-error>
                                    <small class="form-text text-muted">{{ $t('today_is') }} {{ $moment().format("dddd, MMMM Do") }}.<a class="float-right" @click="setDate()">{{ $t('set_tomorrow') }}</a></small>
                                    <!--  <small class="form-text text-muted" v-if="time_to_reply">{{thisPost.user.name}} usually replies {{time_to_reply.toLowerCase()}}.</small> -->
                                </div>
                            </div>
                        </div>
                        <!-- Modal Actions -->
                        <div class="modal-footer">
                            <v-button @click="updateOrder" :loading="form.busy">
                                {{ $t('update') }}
                            </v-button>
                        </div>
                    </form>
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
    props: ['order'],
    name: 'boost-modal',
    data: () => ({
        complete: false,
        payment_loading: false,
        time_to_reply: 0,
        date: "",
        form: new Form({
            'location-meet': '',
            'location-date': ''
        }),

    }),
    computed: {
        ...mapGetters({
            user: 'auth/user'
        })
    },
    watch: {
        'order': function $order(id) {
            this.setData();
        }

        },
        methods: {
            setPaymentLoading(value) {
                this.payment_loading = value
            },
            setDate() {
                this.date = this.$moment().add(1, 'd').hours(13).minute(0).format(this.$moment.HTML5_FMT.DATETIME_LOCAL)
            },
            updateOrder() {
                this.form['location-date'] = this.$moment(this.date, this.$moment.HTML5_FMT.DATETIME_LOCAL).format("X")
                this.form.patch('/api/v1/orders/' + this.order['connect-id']).then(response => {
                    this.complete = true
                    this.$emit('orderUpdated', response.data)
                    document.getElementById('modal-edit-order').modal('hide')
                    let texts = [this.$t('nice'), this.$t('awesome'), this.$t('high_five'), this.$t('cool'), this.$t('great_job'), this.$t('nicely_done')]

                    let label_text = texts[Math.floor(Math.random() * texts.length)] + "!"
                    swal({
                        toast: true,
                        title: this.$t(label_text),
                        text: `${this.$t('you_updated_this_order')}.`,
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

            },
            setData() {
                this.form['location-meet'] = this.order['location-meet']
                this.date = this.$moment(this.order['location-date'], "X").format(this.$moment.HTML5_FMT.DATETIME_LOCAL)
            }
        }
    }
</script>