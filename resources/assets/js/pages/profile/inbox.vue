<template>
    <div>
        <transition-group name="fade" mode="out-in">
            <card :po="post" v-for="(post, index) in posts" :key="post['post-id']">
                <card-header :link="'/user/'+post.buyer['user-id']" :title="fullNames[index]" :subtitle="getHumanDate(post.timestamp)" :image="post.buyer.profilepic">
                </card-header>
                <card-content :text="post.comment">
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
                                <h6 v-else class="mb-1 text-primary">Waiting for your confirmation...</h6>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action flex-column align-items-start disabled">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 v-if="post.replied && Date.now() < Number(post['location-date']+'000')" class="mb-1 text-primary">Waiting for meeting...</h6>
                                <h6 class="mb-1 text-primary" v-else-if="post['location-date'] < post.replied">Waiting for you to set a new meeting time...</h6>
                                <h6 v-else class="mb-1 text-muted">Actual meeting</h6>
                                <small class="text-muted" v-if="post.replied && post['location-date'] > post.replied">{{getHumanDate(post['location-date'])}}</small>
                            </div>
                            <p v-if="Date.now() < Number(post['location-date']+'000') && post['location-date'] > post.replied" class="mb-1">{{$moment(post['location-date'], 'X').calendar()}}, {{post['location-meet']}}.</p>
                            <p v-else-if="!post.replied" class="mb-1 text-danger">{{$moment(post['location-date'], 'X').calendar()}}, {{post['location-meet']}}.</p>
                        </a>
                        <a class="list-group-item list-group-item-action flex-column align-items-start disabled">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 v-if="post.replied && Date.now() > Number(post['location-date']+'000') && post['location-date'] > post.replied" class="mb-1 text-primary">Rate your meeting</h6>
                                <h6 v-else class="mb-1 text-muted">Rate your meeting</h6>
                            </div>
                        </a>
                    </div>
                </card-content>
                <card-footer :po="post" v-if="Date.now() < Number(post['location-date']+'000') || post.replied == null || !checkHasRating(post)" :loading="post.loading">
                    <template v-if="post.replied === null">
                        <a @click="accept(post['connect-id'], index)" class="link" onclick="ga('send', 'event', 'Button', 'Click', 'Reply');">{{ $t('accept') }}</a>
                        <a @click="deleteOrder(post['connect-id'], index)" class="link">{{ $t('decline') }}</a>
                    </template>
                    <template v-else-if="Date.now() < Number(post['location-date']+'000') || post['location-date'] < post.replied">
                        <a class="link" @click="selectedOrder = post" data-toggle="modal" data-target="#modal-edit-order">{{ $t('edit') }}</a>
                        <a @click="deleteOrder(post['connect-id'], index)" class="link">{{ $t('cancel') }}</a>
                    </template>
                    <template v-else>
                        <a @click="rate(post, index)" class="link">{{ $t('rate_your_meeting_with') }} {{ post.buyer.name }}</a>
                    </template>
                </card-footer>
            </card>
        </transition-group>
        <card-placeholder v-if="loading"></card-placeholder>
        <card v-if="!loading && posts.length === 0">
            <div class="card-header text-center">
                <svg width="40%" clip-rule="evenodd" fill-rule="evenodd" image-rendering="optimizeQuality" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" version="1.0" viewBox="0 0 34560 13716" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                    <path class="fil0" d="m14530 1913c0 106-1 234-2 379 347 410 1347 997 1520 1120 1168 835 1978 1673 3278 2404 438 247 802 415 1239 692 904 575 3016 2193 3997 1127 184-200 370-473 572-697 1918-2133 4894-3716 7207-5410 256-187 804-579 1026-901-3-8-6-16-9-24-943-334-9999 625-11520 751-1143 95-2099 155-3251 138-612-8-3413-54-4058 399 1 7 1 14 1 22zm-7 1096c-15 2788 38 8635 1252 9419 180 116 1096 12 1343-4 4822-314 9727-1425 14525-1475 813-9 1586 19 2387 89-19-2427-127-4995-294-7407-36-517-107-1594-229-2363-259 259-574 476-858 683-2486 1821-5638 3430-7562 5869-514 651-1127 819-1925 637-1237-281-2564-1390-3739-1994-1416-728-2233-1536-3460-2462-463-350-1e3 -632-1440-992zm19276-2680c114 52 177 179 145 304-6 17-13 33-20 49 204 779 284 2206 318 2684 178 2445 285 5054 311 7508 5 492 68 252-292 711-976-97-1902-127-2883-108-4606 90-9309 1120-13935 1450-403 29-1488 153-1826 7-1741-751-1645-7912-1615-10505-256-460-101-889 606-1145 1349-488 4092-247 5664-340 2664-156 5386-478 8055-703 725-61 4928-493 5392-28 28 28 54 68 80 116z" />
                    <path class="fil1" d="m14268 1913c0 1535-273 10904 1719 10831 6083-222 12856-1999 18301-1419 44 5-202-10418-747-10919-636-586-11578 834-14193 834-1481 0-7911-339-3904 2086 1207 730 2342 2046 4278 2994 1323 648 3905 3042 5154 1345 2164-2940 8524-5968 8815-7097" />
                    <path class="fil0" d="m9799 6095c-3113-286-4653-176-7738 503-581 128-1161 259-1742 389-141 31-281-58-313-199-31-141 58-281 199-313 581-129 1162-261 1744-389 3137-690 4732-803 7899-512 144 13 250 141 236 285-13 144-141 250-285 236z" />
                    <path class="fil1" d="m9824 5834c-4177-391-5445-20-9562 897" />
                    <path class="fil0" d="m11072 8917c-2138-792-4013 46-6167 167-145 7-267-106-273-250-7-144 105-267 250-273 2285-128 4059-992 6383-131 134 53 200 205 147 340-53 134-206 200-340 147z" />
                    <path class="fil1" d="m11168 8673c-2129-843-4296 63-6275 150" />
                    <path class="fil0" d="m11915 11325c-4493 7-6057 434-10145 2275l-205 93c-132 59-287 1-346-131-60-132-2-287 130-347l206-93c4155-1871 5791-2314 10360-2320 145 0 262 117 262 262 0 144-117 261-262 261z" />
                    <path class="fil1" d="m11915 11064c-4548 0-6024 383-10458 2390" />
                </svg>
                <div class="facebook-name m-0">Inbox is cool. It'll keep track of your sold textbooks and upcoming meetings with others.</div>
                <div class="facebook-date m-0">Sell your first textbook and you'll see the magic!</div>
            </div>
            <card-footer>
                <router-link class="link" to="/sell">{{ $t('sell_a_book') }}</router-link>
            </card-footer>
        </card>
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
import { mapGetters } from 'vuex'
import Form from 'vform'
import swal from 'sweetalert2'
import EditOrderModal from '~/components/modals/OrderEdit'


export default {
    scrollToTop: false,
    props: ['user'],
    components: {
        EditOrderModal
    },
    metaInfo() {
        return { title: this.$t('inbox') }
    },

    computed: {
        fullNames: function() {
            return this.posts.map(function(item) {
                return item.buyer.name;
            })
        }
    },

    data: () => ({
        posts: [],
        page: 1,
        selectedOrder: [],
        loading: false,
        rateForm: new Form({
            rating: '',
            comment: ''
        })
    }),

    created() {
        this.getPosts()
    },

    methods: {
        async getPosts() {
            this.loading = true
            var data = this
            await axios('/api/v1/orders?seller=' + this.user['user-id'] + '&paginate=false').then(function(response) {
                data.page++
                data.loading = false
                $.each(response.data, function(res, val) {
                    val.loading = false
                    data.posts.push(val)
                    data.$store.dispatch('book/addBook', val.post.textbook)
                })
            })
        },
        checkHasRating(post) {
            if (post.ratings.some(e => e.rated_by === this.user['user-id'])) {
                return true;
            }
            return false;
        },
        async accept(id, index) {
            this.posts[index].loading = true
            // how to update with reloading all the phone list?
            await axios.post('/api/v1/orders/' + id + '/accept').then(response => {
                //data.posts.splice(index, 1, response.data)
                this.$set(this.posts[index], 'replied', response.data.replied)
                this.posts[index].loading = false
                this.user.unread_orders--
                this.$store.dispatch('auth/updateUser', { user: this.user })

            })
        },
        rate(post, index) {
            this.rateForm['connect-id'] = post['connect-id'];
            this.rateForm.index = index;

            $('#modal-rate-client').modal('show');
        },
        async rateMeeting() {
            var data = this
            await this.rateForm.post('/api/v1/ratings').then(function(response) {
                data.$set(data.posts[data.rateForm.index], 'ratings', [response.data])
                $('#modal-rate-client').modal('hide')
            })
        },
        getHumanDate: function(date) {
            date = Number(date);
            return this.$moment(date, 'X').fromNow();
        },
        deleteOrder(id, index) {
            var data = this
            this.posts[index].loading = true
            swal({
                    type: 'warning',
                    title: data.$t('you_are_about_to_cancel_this_meeting'),
                    text: "If you just want to choose a different time or place, tap 'Go back' and then 'Edit' after accepting the meeting",
                    confirmButtonText: data.$t('cancel_meeting'),
                    cancelButtonText: data.$t('go_back'),
                    showCancelButton: true
                })
                .then(async (result) => {
                    console.log(result)
                    if (result) {
                        axios.delete('/api/v1/orders/' + id).then(function(response) {
                            if (!data.posts[index].replied) {
                                data.user.unread_orders--
                            }
                            swal(
                                data.$t('you_canceled_the_meeting'),
                                `${data.posts[index].buyer.name} ${data.$t('has_been_informed').toLowerCase()}.`,
                                'success'
                            )
                            data.$delete(data.posts, index)
                        })
                    }
                }).catch(res => {
                    this.posts[index].loading = false

                })
        },
        updateOrder(response) {
            this.posts.find(post => post['connect-id'] === response['connect-id'])['location-date'] = response['location-date']
            this.posts.find(post => post['connect-id'] === response['connect-id'])['location-meet'] = response['location-meet']
        }
    }

}
</script>
<style scoped>
.fil1 {
    fill: none
}

.fil0 {
    fill: #0C1726
}

label>img {
    display: block;
}


/*! CSS Used from: https://jb2:7890/css/main.css */


/*! @import https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css */


/*! CSS Used from: https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css */


/*! end @import */

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


/*! CSS Used from: Embedded */

.radio-grp .radio-btn input[type='radio']:checked~label {
    opacity: 1;
}

.radio-grp .radio-btn input[type='radio']:checked~label:after {
    content: "●";
    color: #909090;
    font-size: 0.7rem;
}

label {
    width: 100% !important;
    padding-bottom: 0 !important;
    opacity: 0.5;
    transition: all .2s ease !important;
}

label:after {
    content: "●";
    color: transparent;
    font-size: 0.7rem;
}
</style>