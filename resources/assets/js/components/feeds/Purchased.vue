<template>
    <div>
        <card v-for="(post, index) in totalBought" :key="post['post-id']">
            <template v-if="post.replied && checkHasRating(post)">
                <card-header :title="post.post.textbook['book-title']" :subtitle="post.post.textbook.average_price" :image="post.post.textbook['image-url']" image-shape="square" :link="'/textbook/'+post.post.isbn">
                </card-header>
                <card-footer>
                    <router-link class="link" :to="'/sell/'+post.post.isbn">{{ $t('sell') }}</router-link>
                </card-footer>
            </template>
            <template v-else>
                <card-header :title="post.post.user.name" :subtitle="getHumanDate(post.timestamp)" :image="post.post.user.profilepic" :link="'/user/'+post.post['user-id']">
                </card-header>
                <card-content>
                    <card style="margin-top:1rem;">
                        <card-header :link="'/post/'+post.post['post-id']" :title="post.post.textbook['book-title']" :subtitle="post.post.price" :image="post.post.textbook['image-url']" imageShape="square">
                        </card-header>
                    </card>
                    <div class="list-group" style="margin-top:1rem;" v-if="!checkHasRating(post) || !post.replied">
                        <a class="list-group-item list-group-item-action flex-column align-items-start disabled">
                            <div class="d-flex w-100 justify-content-between">
                                <template v-if="post.replied">
                                    <h6 class="mb-1 text-muted">Order confirmed</h6>
                                    <small class="text-muted">{{getHumanDate(post.replied)}}</small>
                                </template>
                                <h6 v-else class="mb-1 text-primary">Waiting for confirmation...</h6>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action flex-column align-items-start disabled">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 v-if="post.replied && Date.now() < Number(post['location-date']+'000')" class="mb-1 text-primary">Waiting for meeting...</h6>
                                <h6 v-else class="mb-1 text-muted">Actual meeting</h6>
                                <small class="text-muted" v-if="post.replied">{{getHumanDate(post['location-date'])}}</small>
                            </div>
                            <p v-if="post.replied && Date.now() < Number(post['location-date']+'000')" class="mb-1">{{$moment(post['location-date'], 'X').calendar()}}, {{post['location-meet']}}.</p>
                        </a>
                        <a class="list-group-item list-group-item-action flex-column align-items-start disabled">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 v-if="post.replied && Date.now() > Number(post['location-date']+'000')" class="mb-1 text-primary">Rate your meeting</h6>
                                <h6 v-else class="mb-1 text-muted">Rate your meeting</h6>
                            </div>
                        </a>
                    </div>
                </card-content>
                <card-footer :loading="post.loading">
                    <router-link v-if="post.replied && checkHasRating(post)" class="link" :to="'/sell/'+post.textbook.isbn">{{ $t('sell') }}</router-link>
                    <a v-else-if="post.replied && Date.now() > Number(post['location-date']+'000')" class="link" @click="rate(post, index)">{{ $t('rate_your_meeting_with') }} {{post.post.user.name}}</a>
                    <template v-else>
                        <a class="link" @click="selectedOrder = post" data-toggle="modal" data-target="#modal-edit-order">{{ $t('edit') }}</a>
                        <a class="link" @click="deleteOrder(post['connect-id'], index)">{{ $t('cancel') }}</a>
                    </template>
                </card-footer>
            </template>
        </card>
        <card v-if="!loading && (purchased.length === 0 || totalBought.length === 0)">
            <div class="card-header text-center">
                <svg width="60%" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 2000 1110.9" style="enable-background:new 0 0 2000 1110.9;max-width:200px;" xml:space="preserve">
                    <g transform="translate(0 947.64)">
                        <g transform="matrix(3.501 0 0 3.501 108.94 -2757.7)">
                            <path class="st0" d="M7.9,766.5h494.3c5,0,9,4,9,9v5.4c0,5-4,9-9,9H7.9c-5,0-9-4-9-9v-5.4C-1.1,770.5,2.9,766.5,7.9,766.5z" />
                            <path class="st1" d="M231.9,607.6h0.9c9.1,0,16.5,7.4,16.5,16.5v121.2c0,9.1-7.4,16.5-16.5,16.5h-0.9c-9.1,0-16.5-7.4-16.5-16.5
            V624.2C215.3,615,222.7,607.6,231.9,607.6z" />
                            <path class="st1" d="M270.8,607.6h8.7c9.1,0,16.5,7.4,16.5,16.5v121.2c0,9.1-7.4,16.5-16.5,16.5h-8.7c-9.1,0-16.5-7.4-16.5-16.5
            V624.2C254.3,615,261.7,607.6,270.8,607.6z" />
                            <path class="st0" d="M315.6,607.6h8.7c9.1,0,16.5,7.4,16.5,16.5v121.2c0,9.1-7.4,16.5-16.5,16.5h-8.7c-9.1,0-16.5-7.4-16.5-16.5
            V624.2C299.1,615,306.5,607.6,315.6,607.6z" />
                            <path class="st2" d="M53,618.2l7.1,2.3c8.3,2.7,13,11.7,10.3,20.1L35.2,751.7c-2.6,8.4-11.6,12.9-19.9,10.2l-7.1-2.3
            c-8.3-2.7-13-11.7-10.3-20.1l35.1-111.1C35.7,620.1,44.6,615.5,53,618.2z" />
                            <path class="st3" d="M99.4,617.9l7.1,2.2c8.4,2.6,13.1,11.6,10.5,20L82.8,751.5c-2.6,8.4-11.4,13-19.8,10.4l-7.1-2.2
            c-8.4-2.6-13.1-11.6-10.5-20l34.2-111.4C82.1,619.9,91,615.3,99.4,617.9z" />
                            <path class="st2" d="M147.7,618.6l7.1,2.4c8.3,2.8,12.8,11.8,10.1,20.2l-36.2,110.7c-2.7,8.3-11.7,12.8-20,10l-7.1-2.4
            c-8.3-2.8-12.8-11.8-10.1-20.2l36.2-110.7C130.4,620.3,139.4,615.8,147.7,618.6z" />
                            <polygon class="st4" points="166.1,558.7 208.3,559.3 207.2,760.7 165.1,760.1        " />
                            <path class="st1" d="M359,696h82.9c6.3,0,11.4,5.1,11.4,11.4V750c0,6.3-5.1,11.4-11.4,11.4H359c-6.3,0-11.4-5.1-11.4-11.4v-42.5
            C347.6,701.2,352.7,696,359,696z" />
                            <path class="st1" d="M352.3,670.5h96.4c4.2,0,7.7,3.4,7.7,7.7v10.2c0,4.2-3.4,7.7-7.7,7.7h-96.4c-4.2,0-7.7-3.4-7.7-7.7v-10.2
            C344.6,673.9,348,670.5,352.3,670.5z" />
                            <rect x="347.6" y="696" class="st1" width="105.7" height="65.4" />
                            <rect x="344.6" y="670.5" class="st0" width="111.8" height="25.6" />
                            <path class="st1" d="M386.8,713.9h27.3c1.6,0,3,1.3,3,3v0c0,1.6-1.3,3-3,3h-27.3c-1.6,0-3-1.3-3-3v0
            C383.9,715.2,385.2,713.9,386.8,713.9z" />
                            <path class="st1" d="M359,605.1h82.9c6.3,0,11.4,5.1,11.4,11.4v42.5c0,6.3-5.1,11.4-11.4,11.4H359c-6.3,0-11.4-5.1-11.4-11.4
            v-42.5C347.6,610.2,352.7,605.1,359,605.1z" />
                            <path class="st1" d="M352.3,579.6h96.4c4.2,0,7.7,3.4,7.7,7.7v10.2c0,4.2-3.4,7.7-7.7,7.7h-96.4c-4.2,0-7.7-3.4-7.7-7.7v-10.2
            C344.6,583,348,579.6,352.3,579.6z" />
                            <rect x="347.6" y="605.1" class="st1" width="105.7" height="65.4" />
                            <rect x="344.6" y="579.6" class="st0" width="111.8" height="25.6" />
                            <path class="st1" d="M386.8,622.9h27.3c1.6,0,3,1.3,3,3v0c0,1.6-1.3,3-3,3h-27.3c-1.6,0-3-1.3-3-3v0
            C383.9,624.3,385.2,622.9,386.8,622.9z" />
                            <rect x="313.5" y="672.5" class="st5" width="14.3" height="15.6" />
                            <rect x="313.5" y="636.7" class="st5" width="14.3" height="15.6" />
                            <rect x="313.5" y="708.3" class="st5" width="14.3" height="15.6" />
                            <rect x="230.4" y="626.7" class="st6" width="3.9" height="15.6" />
                            <rect x="230.4" y="731.2" class="st6" width="3.9" height="15.6" />
                            <rect x="230.4" y="679" class="st6" width="3.9" height="15.6" />
                            <path class="st1" d="M259.2,629.4h31.9c1.6,0,3,1.3,3,3v0c0,1.6-1.3,3-3,3h-31.9c-1.6,0-3-1.3-3-3v0
            C256.2,630.8,257.6,629.4,259.2,629.4z" />
                            <path class="st1" d="M259.2,733.9h31.9c1.6,0,3,1.3,3,3v0c0,1.6-1.3,3-3,3h-31.9c-1.6,0-3-1.3-3-3v0
            C256.2,735.2,257.6,733.9,259.2,733.9z" />
                            <rect x="268" y="672.5" class="st6" width="14.3" height="15.6" />
                            <polygon class="st7" points="174.9,591.2 199.1,591.6 198.4,728.2 174.3,727.8        " />
                            <polygon class="st8" points="174.9,570.3 199.1,570.3 198.4,581.3 174.3,581.3        " />
                            <polygon class="st8" points="174.9,737.5 199.1,737.5 198.4,748.5 174.3,748.5        " />
                        </g>
                    </g>
                </svg>
                <div class="facebook-name m-0 center">{{ $t('you_havent_bought_a_book_recently') }}</div>
                <div class="facebook-date m-0 center">{{ $t('explore_books_for_university') }}</div>
            </div>
            <card-footer>
                <router-link class="link" to="/home">{{ $t('discover') }}</router-link>
            </card-footer>
        </card>
        <card-placeholder v-else-if="loading"></card-placeholder>
        <!-- Rate Client Modal -->
        <div class="modal fade" id="modal-rate-client" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $t('rate_your_meeting') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Rate Client Form -->
                    <form class="form-horizontal" role="form" @submit.prevent="rateMeeting" @keydown="rateForm.onKeydown($event)">
                        <div class="modal-body">
                            <!-- rating -->
                            <div class="form-group row">
                                <label class="col-md-3 control-label">{{ $t('rating') }}</label>
                                <div class="form-group col-md-7 m-0">
                                    <div class="row">
                                        <div class="radio-grp input-style" style="height:initial;">
                                            <div class="radio-btn">
                                                <input v-model="rateForm.rating" type="radio" id="10k" name="rating" value="5">
                                                <label for="10k"><img style="margin: 0 auto;" src="/images/Like.svg" width="70"></label>
                                            </div>
                                            <div class="radio-btn">
                                                <input v-model="rateForm.rating" type="radio" id="25k" name="rating" value="1">
                                                <label for="25k"><img style="margin: 0 auto;" src="/images/Dislike.svg" width="70"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <has-error :form="rateForm" field="rating"></has-error>
                                </div>
                            </div>
                            <!-- Comment -->
                            <div class="form-group row">
                                <label class="col-md-3 control-label">{{ $t('comment') }}</label>
                                <div class="col-md-7">
                                    <textarea class="form-control" name="comment" v-model="rateForm['comment']" :class="{ 'is-invalid': rateForm.errors.has('comment') }" maxlength="250">{{rateForm['comment']}}</textarea>
                                    <has-error :form="rateForm" field="comment"></has-error>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Actions -->
                        <div class="modal-footer">
                            <v-button @click="rateMeeting" :loading="rateForm.busy">
                                {{ $t('save') }}
                            </v-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <edit-order-modal :order="selectedOrder" @orderUpdated="updateOrder" />
    </div>
</template>
<script>
import axios from 'axios'
import Form from 'vform'
import swal from 'sweetalert2'
import EditOrderModal from '~/components/modals/OrderEdit'

export default {
    props: ['user', 'posts', 'inactivePosts'],
    components: {
        EditOrderModal
    },
    computed: {
        totalBought() {
            var self = this
            return this.purchased.filter(function(post) {
                return (!post.replied || !self.checkHasRating(post)) || (post.replied && self.checkHasRating(post) && self.posts.filter(e => e.isbn === post.post.isbn).length === 0 && self.inactivePosts.filter(e => e.isbn === post.post.isbn).length === 0)
            })
        }
    },

    data: () => ({
        purchased: [],
        page: 1,
        loading: false,
        selectedOrder: [],
        rateForm: new Form({
            rating: '',
            comment: ''
        })
    }),

    mounted() {
        this.getPurchased()
    },

    methods: {
        getHumanDate: function(date) {
            date = Number(date);
            return this.$moment(date, 'X').fromNow();
        },
        checkHasRating(post) {
            if (post.ratings.some(e => e.rated_by === this.user['user-id'])) {
                return true;
            }
            return false;
        },
        async getPurchased() {
            this.loading = true
            var data = this
            await axios('/api/v1/orders?buyer=' + this.user['user-id'] + '&paginate=false').then(response => {
                this.page++
                    this.loading = false
                $.each(response.data, function(res, val) {
                    val.loading = false
                    data.purchased.push(val)
                    data.$store.dispatch('book/addBook', val.post.textbook)
                })
            })
        },

        deleteOrder(id, index) {
            var data = this
            this.purchased[index].loading = true
            swal({
                    type: 'warning',
                    title: data.$t('you_are_about_to_cancel_this_meeting'),
                    text: "If you just want to choose a different time or place, tap 'Go back' and then 'Edit'",
                    confirmButtonText: data.$t('cancel_meeting'),
                    cancelButtonText: data.$t('go_back'),
                    showCancelButton: true
                })
                .then(async(result) => {
                    console.log(result)
                    if (result) {
                        axios.delete('/api/v1/orders/' + id).then(function(response) {
                            swal(
                                data.$t('you_canceled_the_meeting'),
                                `${data.purchased[index].post.user.name} ${data.$t('has_been_informed').toLowerCase()}.`,
                                'success'
                            )
                            data.$delete(data.purchased, index)
                            data.$ga.event({
                                eventCategory: 'User Event',
                                eventAction: 'Canceled an order'
                            })
                        })
                    }
                }).catch(e => {
                    this.purchased[index].loading = false
                })
        },
        rate(post, index) {
            this.rateForm['connect-id'] = post['connect-id']
            this.rateForm.index = index

            $('#modal-rate-client').modal('show')
        },
        async rateMeeting() {
            await this.rateForm.post('/api/v1/ratings').then(response => {
                this.$set(this.purchased[this.rateForm.index], 'ratings', [response.data])
                $('#modal-rate-client').modal('hide')
                this.$ga.event({
                    eventCategory: 'User Event',
                    eventAction: 'Rated a meeting'
                })
            })
        },
        updateOrder(response) {
            this.purchased.find(post => post['connect-id'] === response['connect-id'])['location-date'] = response['location-date']
            this.purchased.find(post => post['connect-id'] === response['connect-id'])['location-meet'] = response['location-meet']
        }
    }
}
</script>
<style scoped>
label>img {
    display: block;
}

.radio-grp {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    text-align: center;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    max-width: 700px;
    margin: 0 auto;
}

.radio-grp:after {
    display: table;
    clear: both;
    content: ' ';
}

.radio-grp .radio-btn {
    width: 50%;
}

.radio-grp .radio-btn:last-of-type {
    margin-right: 0;
}

.radio-grp .radio-btn input {
    display: none;
}

.radio-grp .radio-btn input[type='radio']:checked~label {
    color: #0c1726;
}

.radio-grp .radio-btn label {
    font-size: 1.4rem;
    display: block;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 90%;
    padding: 1rem 2rem;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-transition: color .2s ease;
    transition: color .2s ease;
    color: #363636;
    color: #bdbdbd;
}

.radio-grp .radio-btn input[type='radio']:checked~label {
    opacity: 1;
}

.radio-grp .radio-btn input[type='radio']:checked~label:after {
    content: "●";
    color: #909090;
    font-size: 0.7rem;
}

label {
    width: 100%!important;
    padding-bottom: 0!important;
    opacity: 0.5;
    transition: all .2s ease!important;
}

label:after {
    content: "●";
    color: transparent;
    font-size: 0.7rem;
}


.st0 {
    fill: #244572;
    stroke: #244572;
    stroke-width: 5;
    stroke-linecap: round;
}

.st1 {
    fill: #3C74BF;
    stroke: #244572;
    stroke-width: 5;
    stroke-linecap: round;
}

.st2 {
    fill: #3C74BF;
    stroke: #244572;
    stroke-width: 5.0001;
    stroke-linecap: round;
}

.st3 {
    fill: #475972;
    stroke: #244572;
    stroke-width: 5.0001;
    stroke-linecap: round;
}

.st4 {
    fill: #244572;
    stroke: #244572;
    stroke-width: 5.0001;
    stroke-linecap: round;
}

.st5 {
    fill: #3C74BF;
    stroke: #244572;
    stroke-linecap: round;
}

.st6 {
    fill: #244572;
    stroke: #244572;
    stroke-linecap: round;
}

.st7 {
    fill: #3C74BF;
    stroke: #244572;
    stroke-width: 5.0002;
    stroke-linecap: round;
}

.st8 {
    fill: #3C74BF;
    stroke: #244572;
    stroke-width: 5.0038;
    stroke-linecap: round;
}

.title {
    max-width: 700px;
    margin: 0 auto;
    color: #b3b3b3;
    font-size: 2rem;
}
</style>