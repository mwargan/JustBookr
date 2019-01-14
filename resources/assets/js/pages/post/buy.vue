<template>
   <div class="row">
    <div class="col-lg-8 m-auto">
        <div :title="$t('sell')">
            <div class="row">
                <div class="col-md-7 m-auto">
                    <h1 class="text-center mb-3">{{ $t('buy_textbook') }}</h1>
                </div>
            </div>
        <checkmark :active="form.successful"></checkmark>
        <div v-show="form.successful" style="text-align: center;"><small class="text-muted">{{$t('you_ordered')}} {{ thisPost.textbook['book-title'] }}</small></div>
        <form v-show="!form.successful" @submit.prevent="post" @keydown="form.onKeydown($event)">
<!--             <alert-success :form="form" :message="$t('info_updated')"></alert-success>
 -->            <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">{{ $t('textbook') }}</label>
                <div class="col-md-7">
                    <card class="m-0">
                        <card-header :title="thisPost.textbook['book-title']" :subtitle="$t('sold_by')+' '+thisPost.user.name" :image="thisPost.textbook['image-url']" image-shape="square" :link="'/textbook/'+thisPost.textbook.isbn">
                        </card-header>
                    </card>
                    <has-error :form="form" field="post-id"></has-error>
                    <small class="form-text text-muted">This is the textbook you are buying.</small>
                </div>
            </div>
            <!-- Where -->
            <div class="form-group row">
                <label for="location-meet" class="col-md-3 col-form-label text-md-right">{{ $t('where_do_you_want_to_meet') }}?</label>
                <div class="col-md-7">
                    <select v-model="form['location-meet']" name="location-meet" class="form-control" :class="{ 'is-invalid': form.errors.has('location-meet') }" :placeholder="$t('example')+': '+$t('at_the_library')" required autofocus>
                        <option selected>{{ $t('at_the_cafeteria') }}</option>
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
                    <small class="form-text text-muted" v-if="time_to_reply">{{thisPost.user.name}} usually replies {{time_to_reply.toLowerCase()}}.</small>
                </div>
            </div>
            <!-- Message -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">{{ $t('message') }} <small class="text-muted">{{ $t('optional') }}</small></label>
                <div class="col-md-7">
                    <input type="text" v-model="form.comment" name="comment" class="form-control" :class="{ 'is-invalid': form.errors.has('comment') }" data-hj-whitelist>
                    <has-error :form="form" field="comment"></has-error>
                    <small class="form-text text-muted">Include an optional message for the seller.</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">{{ $t('payment_method') }}</label>
                <div class="col-md-7">
                    <a class="list-group-item list-group-item-action flex-column align-items-start disabled">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-0">{{ $t('cash_payment') }}</h6>
                            <small><fa icon="money-bill" fixed-width/></small>
                        </div>
                    </a>
                    <small class="form-text text-muted">{{ $t('meet_with') }} {{ thisPost.user.name }} {{ form['location-meet'].toLowerCase() }}, {{ $t('pay_by_cash').toLowerCase() }}.</small>
                </div>
            </div>
            <input type="hidden" v-model="form['post-id']" name="post-id">
            <!-- Submit Button -->
            <div class="form-group row">
                <div class="col-md-7 offset-md-3">
                    <v-button type="primary" class="btn-block" :loading="form.busy">{{ $t('buy_for') }} {{thisPost.price}}</v-button>
                </div>
            </div>
        </form>
        <div v-show="!form.successful" style="text-align: center;"><small class="text-muted"><fa icon="compass" fixed-width/> {{thisPost.university['uni-name']}}</small></div>
    </div>
</div>
</div>
</template>
<script>
import Form from 'vform'
import axios from 'axios'
import { mapGetters } from 'vuex'
import store from '~/store'
import swal from 'sweetalert2'

export default {
    scrollToTop: true,
    metaInfo() {
        return { title: this.$t('buy') }
    },
    beforeRouteEnter(to, from, next) {
        store.dispatch('post/fetchPost', to.params.id).then(response => {
            // the above state is not available here, since it
            next()
        }, error => {
            // handle error here
        })
    },
    data: () => ({
        thisPost: null,
        date: "",
        form: new Form({
            'post-id': '',
            'location-meet': '',
            'location-date': '',
            comment: ''
        }),
        time_to_reply: ''
    }),
    computed: mapGetters({
        user: 'auth/user',
        thisBook: 'post/getPostById'
    }),
    created() {
        this.thisPost = this.thisBook(this.$route.params.id)
        this.form['post-id'] = this.thisPost['post-id']
        this.form['user-id-buy'] = this.user['user-id']
        this.setDate()
        this.form['location-meet'] = this.$t('at_the_cafeteria')
        axios('/api/v1/users/'+this.thisPost['user-id']+'/time-to-reply').then(data => {
            console.log(data);
            if(data.data.time_to_reply && data.data.count_of_sales > 1) {
                this.time_to_reply = this.$moment().add(data.data.time_to_reply, 'm').fromNow();
            }
        });
    },

    methods: {
        setDate() {
            this.date = this.$moment().add(1, 'd').hours(13).minute(0).format(this.$moment.HTML5_FMT.DATETIME_LOCAL)
        },
        async post() {
            // Register the user.
            this.form['location-date'] = this.$moment(this.date, this.$moment.HTML5_FMT.DATETIME_LOCAL).format("X")
            await this.form.post('/api/v1/orders').then(response => {
                this.form.reset()
                this.date = ""
            }, function(response) {
                swal({
                  type: 'error',
                  title: 'You don\t have permission to do this!',
                  text: 'This usually means that this post has already been sold or is generally not available at your university.',
                  reverseButtons: true
                })
            })
        }
    }
}
</script>
<style scoped>
.invalid-feedback {
    display: block;
}
</style>