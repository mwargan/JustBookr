<template>
    <div>
        <div class="title">{{ $t('on_campus') }}</div>
        <template v-if="post && loading === false">
            <!-- Boosted offers card -->
            <card v-for="(post, index) in boostedPosts" :key="'BOOSTED_POST_'+post['post-id']">
                <card-header :title="post.user.name" :subtitle="post.price" :image="post.user.profilepic" :link="'/user/'+post.user['user-id']" sponsored="Boosted" />
                <card-content :text="post['post-description']">
                </card-content>
                <card-footer :post-id="post['post-id']" v-if="!user || post.user['user-id'] != user['user-id'] && post.status === 1"></card-footer>
                <card-footer :post-id="post['post-id']" v-else-if="user && post.user['user-id'] == user['user-id'] && post.status === 1 && post.boosts.length == 0">
                    <a href="#" class="link" @click="modalPost = post" data-toggle="modal" data-target="#boostModal">
                {{$t('boost_your_post')}}
                </a>
                </card-footer>
            </card>
            <!-- Student offers card -->
            <card v-for="(post, index) in sortedPosts" :key="'POST_'+post['post-id']">
                <card-header :title="post.user.name" :subtitle="post.price" :image="post.user.profilepic" :link="'/user/'+post.user['user-id']" />
                <card-content :text="post['post-description']">
                </card-content>
                <card-footer :post-id="post['post-id']" v-if="!user || post.user['user-id'] != user['user-id'] && post.status === 1"></card-footer>
                <card-footer :post-id="post['post-id']" v-else-if="user && post.user['user-id'] == user['user-id'] && post.status === 1 && post.boosts.length == 0">
                    <a href="#" class="link" @click="modalPost = post" data-toggle="modal" data-target="#boostModal">
                {{$t('boost_your_post')}}
                </a>
                </card-footer>
            </card>
            <!-- Business offers card -->
            <card v-for="(post, index) in stand_posts" :key="'BUSINESS_POST_'+post['id']">
                <card-header :title="post.stand.business.name" :subtitle="post.price" sponsored="Sponsored" :image="post.stand.business.logo" :link="'/business/'+post.stand.business.id">
                </card-header>
                <card-content :text="post.description">
                </card-content>
                <card-footer>
                    <router-link class="link" :to="'/stand/'+post.stand.id">{{ $t('learn_more') }}
                    </router-link>
                </card-footer>
            </card>
        </template>
        <!-- Loading card -->
        <card-placeholder v-else-if="loading"></card-placeholder>
        <!-- No available posts card -->
        <card v-else>
            <card-header :title="$t('nobody_is_selling_this_book_at_your_uni_right_now')+'.'">
            </card-header>
            <card-footer>
                <router-link class="link" :to="'/textbook/'+book.isbn+'/info'">Get notified when there is a new post
                </router-link>
            </card-footer>
        </card>
        <div class="title">{{ $t('delivered_to_your_door') }}</div>
        <!-- Amazon card -->
        <card>
            <card-header title="Amazon" :subtitle="$t('may_have_a_copy_of_this_textbook')" image="https://lh3.googleusercontent.com/mIeBLLu8xOi-1bPbtRO_HYb5d1VchJDLDH4hebMO7R-GNOfueGDtHCKgPWFjwyCAORQ=w90">
            </card-header>
            <card-footer>
                <a class="link" @click="hitGA()" target="_BLANK" rel="noopener" :href="'https://www.amazon.com/s//ref=as_li_ss_tl?field-keywords='+$route.params.isbn+'&linkCode=ll2&tag=justbookr01-20'">{{ $t('check') }}
                </a>
            </card-footer>
        </card>
        <!-- Other editions card -->
        <feed-other-editions :book="book" :user="user"></feed-other-editions>
        <div style="text-align: center;">
            <small class="text-muted" v-if="isUniBased"><fa icon="compass" fixed-width/> {{user.university['uni-name']}}</small>
            <small class="text-muted" v-else>{{ $t('log_in_to_see_posts_at_your_university') }}</small>
        </div>
        <boost-modal :post="modalPost" @postPromoted="boostPost" />
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import BoostModal from '~/components/modals/PostBoost'

export default {
    scrollToTop: true,
    props: ['book', 'user'],
    components: {
        BoostModal
    },
    metaInfo() {
        return {
            title: this.book['book-title'] + ' ' + this.$t('posts'),
            meta: [
                { name: 'description', content: this.book['book-des'], vmid: 'description' },
                { property: 'og:image', content: this.book['image-url'], vmid: 'og:image' }
            ]
        }
    },

    computed: {

        isUniBased: function() {
            return this.user && this.user['uni-id'] && this.user.university['uni-name']
        },
        boostedPosts() {
            return this.posts.filter(function(post) {
                return post.boosts.length > 0
            })
        },
        sortedPosts: function() {
            function compare(a, b) {
                if (!b.user.points)
                    return 0
                else
                    return b.user.points - a.user.points
            }
            return this.posts.sort(compare).filter(function(post) {
                return post.boosts.length == 0
            })
        }
    },

    data: () => ({
        posts: [],
        stand_posts: [],
        page: 1,
        loading: false,
        modalPost: {}
    }),
    watch: {
        '$route.params.isbn': function(id) {
            this.getPosts()
            this.getRelated()
        }
    },
    created() {
        this.getPosts()
        this.getStandPosts()
    },

    methods: {

        async getPosts() {
            this.loading = true
            var data = this
            var uni = ""
            if (this.user && this.user['uni-id']) {
                uni = "&university=" + (this.user['uni-id'])
            }
            await axios('/api/v1/posts?isbn=' + this.$route.params.isbn + '&paginate=false&available=true&active=true' + uni).then(function(response) {
                data.page++
                    data.$set(data, 'posts', response.data)
                $.each(response.data, function(res, val) {
                    val.textbook = data.book
                    data.$store.dispatch('post/addPost', val)
                    val.user.university = val.university
                    data.$store.dispatch('user/addUser', val.user)
                })
                data.loading = false
            })
        },
        async getStandPosts() {
            this.loading = true
            var data = this
            var uni = ""
            if (this.user && this.user['uni-id']) {
                uni = "&university=" + (this.user['uni-id'])
            }
            await axios('/api/v1/stand-posts?isbn=' + this.$route.params.isbn + '&paginate=false&available=true&active=true' + uni).then(function(response) {
                data.$set(data, 'stand_posts', response.data)
                data.loading = false
            })
        },
        hitGA() {
            this.$ga.event({
                eventCategory: 'User Event',
                eventAction: 'check on Amazon',
                eventLabel: this.$route.params.isbn
            })
        },
        boostPost(response) {
            this.posts.find(post => post['post-id'] === response.post_id).boosts = [true]
        }
    }
}
</script>
<style scoped>
.title {
    max-width: 700px;
    margin: 0 auto;
    color: #b3b3b3;
    font-size: 2rem;
}
</style>