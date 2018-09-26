<template>
    <div>
        <transition-group name="fade" mode="out-in">
            <!-- Welcome card -->
            <card key="welcome-card">
                <card-header :title="welcome_text" :subtitle="welcome_subtext" image="/images/logoDark.svg" image-shape="original" :link="welcome_link">
                </card-header>
            </card>
            <!-- Boosted posts card -->
            <card v-for="(post, index) in boostedPosts" :key="'B_'+index">
                <card-header :title="post.user.name" :subtitle="post.price" :image="post.user.profilepic" sponsored="Boosted" :link="'/user/'+post['user-id']">
                </card-header>
                <card-content :text="post['post-description']">
                    <card-content-book :title="post.textbook['book-title']" :subtitle="post.textbook['author']" :image="post.textbook['image-url']" :text="post.textbook['edition']" :isbn="post.textbook.isbn"></card-content-book>
                </card-content>
                <card-footer :post-id="post['post-id']" v-if="post['user-id'] != user['user-id'] && post.status === 1"></card-footer>
            </card>
            <card v-for="(post, index) in sortedBooks" :key="'D_'+index">
                <card-content>
                    <card-content-book :title="post['book-title']" :subtitle="post['author']" :image="post['image-url']" :text="edition[index]" :isbn="post.isbn"></card-content-book>
                </card-content>
            </card>
            <card key="share" v-if="!loading && sortedBooks && sortedBooks.length > 4">
                <card-header title="Loving JustBookr?" subtitle="Spread the word!" icon="heart" />
                <card-content>
                    <social-sharing url="https://justbookr.com" quote="Check out this platform for trading textbooks at university!" title="Check out this platform for trading textbooks at university!" description="JustBookr lets you buy and sell textbooks at university. Get started with your Facebook account!" hashtags="justbookr,university,textbook" inline-template>
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
        </transition-group>
        <transition name="fade" mode="out-in">
            <card-placeholder v-if="loading"></card-placeholder>
        </transition>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import uniqBy from 'lodash/uniqBy'

export default {
    scrollToTop: false,
    props: ['user'],
    metaInfo() {
        return { title: this.$t('discover') }
    },

    data: () => ({
        posts: [],
        boostedPosts: [],
        page: 1,
        loading: false
    }),

    computed: {
        edition() {
            return this.posts.map((b) => {
                if (b['edition']) {
                    return `${b['edition']}`
                } else {
                    return null
                }
            })
        },
        welcome_text() {
            let d = new Date();
            let time = d.getHours();
            let string = "Good morning";
            if (time > 11 && time < 18) {
                string = "Good afternoon";
            }
            else if (time > 17) {
                string = "Good evening";
            }
            string += " "+this.user.name;
            return string;
        },
        welcome_subtext() {
            let string = "Thank you for using JustBookr";
            if (this.user.unread_orders) {
                string = "You have unread messages in your inbox";
            }
            else if (this.user.profilepic.match(/JBicon/g)) {
                string = "Set a profile picture by clicking on the placeholder image above";
            }
            return string;
        },
        welcome_link() {
            let string = null;
            if (this.user.unread_orders) {
                string = "/inbox";
            }
            return string;
        },
        sortedBooks() {
            return uniqBy(this.posts, 'isbn')
        },
    },

    created() {
        this.getBoosted()
        this.getSuggested()
        this.getPosts()
    },

    beforeRouteLeave(to, from, next) {
        window.removeEventListener('scroll', this.handleScroll)
        next()
    },

    beforeRouteEnter(to, from, next) {
        next(vm => {
            window.addEventListener('scroll', vm.handleScroll)
        })
    },
    methods: {
        async getSuggested() {
            this.loading = true
            var data = this
            await axios('/api/v1/suggestions/textbooks?university=' + this.user['uni-id']).then(function(response) {
                data.loading = false
                $.each(response.data.data, function(res, val) {
                    data.posts.push(val)
                    data.$store.dispatch('book/addBook', val)
                })
            })
        },
        async getPosts() {
            this.loading = true
            var data = this
            await axios('/api/v1/suggestions/recent?page=' + this.page + '&university=' + this.user['uni-id']).then(function(response) {
                data.page++
                    data.loading = false
                $.each(response.data.data, function(res, val) {
                    data.posts.push(val)
                    data.$store.dispatch('book/addBook', val)
                })
                if (response.data.data.length <= 8) {
                    window.removeEventListener('scroll', data.handleScroll)
                    data.getRecent()
                    return false
                }
            })
        },
        async getRecent() {
            this.loading = true
            var data = this
            await axios('/api/v1/books?university=' + this.user['uni-id']).then(function(response) {
                data.loading = false
                $.each(response.data.data, function(res, val) {
                    data.posts.push(val)
                    data.$store.dispatch('book/addBook', val)
                })
                if (response.data.data.length <= 8) {
                    data.getAllBooks()
                    return false
                }
            })
        },
        async getAllBooks() {
            this.loading = true
            var data = this
            await axios('/api/v1/books').then(function(response) {
                data.loading = false
                $.each(response.data.data, function(res, val) {
                    data.posts.push(val)
                    data.$store.dispatch('book/addBook', val)
                })
            })
        },
        async getBoosted() {
            this.loading = true
            var data = this
            await axios('/api/v1/posts?active=true&available=true&boosted=true&university=' + this.user['uni-id']).then(response => {
                this.loading = false
                $.each(response.data.data, function(res, val) {
                    data.boostedPosts.push(val)
                    data.$store.dispatch('book/addBook', val.textbook)
                })
            })
        },
        handleScroll() {
            if (((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 1300) && this.loading === false) {
                this.getPosts()
            }
        }
    }

}
</script>