<template>
    <div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <h1 class="display-5">Posts</h1>
                <p class="lead">
                    By date posted
                </p>
            </div>
        </div>
        <card>
            <card-content class="mt-2 mb-1">
                <dl v-for="(post, index) in posts">
                    <dt>
                        <router-link :to="'/post/'+post['post-id']">{{ post.textbook['book-title'] }}</router-link>
                    </dt>
                    <dd>By
                        <router-link :to="'/user/'+post.user['user-id']">{{ post.user.name }}</router-link>
                        <small class="d-block">{{ getHumanDate(post.date) }}</small>
                    </dd>
                </dl>
            </card-content>
        </card>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    scrollToTop: false,
    metaInfo() {
        return {
            title: "Post data",
        }
    },

    data: () => ({
        posts: []
    }),
    computed: {
        ...mapGetters({
            // thisBook: 'book/getBookByIsbn'
        }),

    },
    created() {
        this.getPosts()
    },
    methods: {
        async getPosts() {
            var data = this
            await axios('/api/v1/posts?order_by=date&per_page=15').then(function(response) {
                data.$set(data, 'posts', response.data.data)
            })
        },
        getHumanDate(date) {
            date = Number(date)
            console.log(date)
            return this.$moment(date, 'X').fromNow()
        }
    }
}
</script>