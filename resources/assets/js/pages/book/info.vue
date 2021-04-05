<template>
    <div>
        <card>
            <div class="card-header pb-0">
                <div class="facebook-name ml-0">
                    Notifications
                </div>
            </div>
            <card-content class="mt-0 mb-0">
                <book-notification :book="book" :user="user" />
            </card-content>
        </card>
        <transition name="fade" mode="out-in">
            <card>
                <div class="card-header">
                    <div class="facebook-name ml-0">
                        {{ $t('popularity') }}
                        <router-link v-if="user && user['uni-id']" :to="'/university/'+user['uni-id']">{{$t('at').toLowerCase()}} {{user.university['uni-name']}}</router-link>
                    </div>
                </div>
                <card-content class="mt-0 mb-0">
                    <trend-chart :raw_data="month_data" />
                </card-content>
            </card>
        </transition>
        <transition name="fade" mode="out-in">
            <card>
                <card-header :title="$t('more_info')" />
                <card-content class="mt-2 mb-1">
                    <dl>
                        <dt>{{ $t('isbn') }}</dt>
                        <dd>{{ book.isbn }}</dd>
                    </dl>
                    <dl v-if="book.average_price">
                        <dt>{{ $t('average_price') }}</dt>
                        <dd>{{ book.average_price }}</dd>
                    </dl>
                    <dl v-if="book.tags && book.tags.length > 0">
                        <dt>{{ $t('classification') }} <small class="text-muted"><i>{{ $t('beta') }}</i></small></dt>
                        <dd v-for="tag in book.tags"><span v-if="tag['tag-id'] <= 1000">{{ $t('dewey_decimal') }}: {{ tag['tag-id']-1 }}, </span>{{ tag['t-data'] }}</dd>
                    </dl>
                    <dl v-if="book['book-des']">
                        <details>
                            <summary>
                                <dt class="d-inline">{{ $t('book-des') }}</dt>
                            </summary>
                            <p>
                                <dd>{{ book['book-des'] }}</dd>
                            </p>
                        </details>
                    </dl>
                </card-content>
            </card>
        </transition>
        <transition name="fade" mode="out-in">
            <card>
                <card-header :title="$t('share')" />
                <card-content class="mt-2 mb-1">
                    <social-sharing quote="Check out this book on JustBookr!" hashtags="justbookr,university,textbook" inline-template>
                        <div>
                            <div class="row mb-2">
                                <network network="facebook" class="col-3 text-center align-self-center">
                                    <i class="fab fa-facebook fa-2x fa-fw"></i>
                                </network>
                                <network network="whatsapp" class="col-3 text-center align-self-center">
                                    <i class="fab fa-whatsapp fa-2x fa-fw"></i>
                                </network>
                                <network network="email" class="col-3 text-center align-self-center">
                                    <i class="fa fa-envelope fa-2x fa-fw"></i>
                                </network>
                                <network network="googleplus" class="col-3 text-center align-self-center">
                                    <i class="fab fa-google-plus fa-2x fa-fw"></i>
                                </network>
                            </div>
                            <div class="row mb-2">
                                <network network="linkedin" class="col-3 text-center align-self-center">
                                    <i class="fab fa-linkedin fa-2x fa-fw"></i>
                                </network>
                                <network network="reddit" class="col-3 text-center align-self-center">
                                    <i class="fab fa-reddit fa-2x fa-fw"></i>
                                </network>
                                <network network="skype" class="col-3 text-center align-self-center">
                                    <i class="fab fa-skype fa-2x fa-fw"></i>
                                </network>
                                <network network="sms" class="col-3 text-center align-self-center">
                                    <i class="fa fa-comment fa-2x fa-fw"></i>
                                </network>
                            </div>
                            <div class="row">
                                <network network="telegram" class="col-3 text-center align-self-center">
                                    <i class="fab fa-telegram fa-2x fa-fw"></i>
                                </network>
                                <network network="twitter" class="col-3 text-center align-self-center">
                                    <i class="fab fa-twitter fa-2x fa-fw"></i>
                                </network>
                                <network network="vk" class="col-3 text-center align-self-center">
                                    <i class="fab fa-vk fa-2x fa-fw"></i>
                                </network>
                                <network network="weibo" class="col-3 text-center align-self-center">
                                    <i class="fab fa-weibo fa-2x fa-fw"></i>
                                </network>
                            </div>
                        </div>
                    </social-sharing>
                </card-content>
            </card>
        </transition>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import bookNotification from '~/components/BookNotification.vue'
import trendChart from '~/components/TrendChart.vue'

export default {
    components: { bookNotification, trendChart },
    scrollToTop: false,
    props: ['book', 'user'],
    metaInfo() {
        return {
            title: this.book['book-title'] + ' ' + this.$t('posts'),
            meta: [
                { name: 'description', content: this.book['book-des'], vmid: 'description' },
                { property: 'og:image', content: this.book['image-url'], vmid: 'og:image' }
            ]
        }
    },

    data: () => ({
        month_data: {},
        loaded: false
    }),
    computed: {
        // ...mapGetters({
        //     user: 'auth/user'
        // })

    },
    mounted() {
        this.getTrend()
    },
    watch: {
        'book.isbn': function(id) {
            this.getTrend()
        }
    },
    methods: {
        getTrend() {
            var uni = ''
            if (this.user && this.user['uni-id']) {
                uni = "?past_year=true&university=" + this.user['uni-id'] + "&not_user=" + this.user['user-id']
            }
            axios('/api/v1/books/' + this.book.isbn + "/views" + uni).then(response => {
                this.month_data = response.data
                this.loaded = true
            }).catch(e => {
                this.loaded = true
            })
        }
    }
}
</script>