<template>
    <div>
        <card v-if="!loading && moneyMade">
            <div class="card-header text-center">
                <div class="facebook-name m-0 center text-success">+{{ user.university.country.currency }}{{moneyMade.toLocaleString()}}</div>
                <div class="facebook-date m-0 center">Earned by selling books</div>
            </div>
        </card>
        <card v-if="posts.length > 0 && !loading" v-for="(post, index) in posts" :key="post['post-id']">
            <card-header v-if="!post.order" :title="post.textbook['book-title']" :subtitle="post.price" :image="post.textbook['image-url']" image-shape="square" :link="'/post/'+post['post-id']">
            </card-header>
            <card-header v-else :title="post.textbook['book-title']" :subtitle="post.price+' · Sold to '+post.order.buyer.name" :image="post.textbook['image-url']" image-shape="square" :link="'/inbox'">
            </card-header>
            <card-footer v-if="post.status == 1" :loading="post.loading">
                <a class="link" @click="sharePost(post, index)">{{ $t('share') }}</a>
                <a class="link" @click="edit(post, index)">{{ $t('edit') }}</a>
            </card-footer>
        </card>
        <card v-if="posts.length == 0 && !loading">
            <div class="card-header text-center">
                <div class="facebook-name m-0 center">You haven't sold a book yet</div>
                <div class="facebook-date m-0 center">Books you sell or mark as 'sold' will show here</div>
            </div>
            <card-footer>
                <router-link class="link" to="/sell">{{ $t('sell_books') }}</router-link>
            </card-footer>
        </card>
        <card-placeholder v-if="loading"></card-placeholder>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    props: ['user'],
    computed: {
        moneyMade: function() {
            return this.posts.map(function(item) {
                if (item.order && Date.now() > Number(item.order['location-date'] + '000') && item.order['location-date'] > item.order.replied) {
                    return Number(item.price.slice(1));
                } else if (!item.order) {
                    return Number(item.price.slice(1));
                }
                return 0;
            }).reduce((a, b) => a + b, 0);
        }
    },
    data: () => ({
        posts: [],
        page: 1,
        loading: false,
        views: 0
    }),

    created() {
        this.getPosts()
    },

    methods: {
        async getPosts() {
            this.loading = true
            await axios('/api/v1/posts?user=' + this.user['user-id'] + '&available=false&paginate=false').then(response => {
                this.page++
                this.loading = false
                $.each(response.data, (res, val) => {
                    this.posts.push(val)
                    this.$store.dispatch('book/addBook', val.textbook)
                })
                this.$emit('set-inactive-posts', this.posts);
            })
        }
    }
}
</script>