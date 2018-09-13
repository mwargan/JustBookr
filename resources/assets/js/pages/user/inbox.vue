<template>
    <div>
        <transition-group name="fade" mode="out-in">
            <card :po="post" v-for="(post, index) in posts" :key="post['post-id']">
                <card-header :title="fullNames[index]" subtitle="23 hrs" :image="post.buyer.profilepic">
                </card-header>
                <card-content :text="post.comment">
                    <card style="margin-top:1rem;">
                        <card-header :title="post.post.textbook['book-title']" :subtitle="subtitle[index]" :image="post.post.textbook['image-url']" imageShape="square">
                        </card-header>
                    </card>
                </card-content>
                <card-footer :po="post">
                    <a v-if="!post.replied" href="/buy/?id=1170" class="link" onclick="ga('send', 'event', 'Button', 'Click', 'Reply');">{{ $t('reply_to') }} {{ post.buyer.name }}</a>
                    <a v-else href="/buy/?id=1170" class="link" onclick="ga('send', 'event', 'Button', 'Click', 'Reply');">{{ $t('rate_your_meeting_with') }} {{ post.buyer.name }}</a>
                </card-footer>
            </card>
        </transition-group>
        <card-placeholder v-if="loading"></card-placeholder>
        <card v-if="!loading && posts.length === 0">
            <div class="card-header">
                <div class="facebook-name m-0">Inbox is cool. It'll keep track of sold textbooks and upcoming meetings with others.</div>
                <div class="facebook-date m-0">Sell your first textbook and you'll see the magic!</div>
            </div>
        </card>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    scrollToTop: false,

    metaInfo() {
        return { title: this.$t('inbox') }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
        fullNames: function() {
            return this.posts.map(function(item) {
                return item.buyer.name;
            })
        },
        subtitle() {
            return this.posts.map((b) => {
                //var price = `${this.user.university.country.currency}${b.post.price}`
                return `$13`
            })
        }
    },

    data: () => ({
        posts: [],
        page: 1,
        loading: false
    }),

    created() {
        this.getPosts()
        //window.addEventListener('scroll', this.handleScroll)
    },

    destroyed() {
        window.removeEventListener('scroll', this.handleScroll)
    },

    methods: {
        async getPosts() {
            this.loading = true
            var data = this
            await axios('/api/v1/orders?seller='+this.user['user-id']+'&paginate=false').then(function(response) {
                data.page++
                    data.loading = false
                $.each(response.data, function(res, val) {
                    data.posts.push(val)
                    data.$store.dispatch('book/addBook', val.post.textbook)
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