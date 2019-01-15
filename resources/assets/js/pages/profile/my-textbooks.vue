<template>
    <div>
        <div class="row">
            <div class="col-lg-7">
                <div key="1x" class="title">{{ $t('bought') }}</div>
                <feed-purchased :user="user" :posts="posts" :inactivePosts="inactivePosts" />
            </div>
            <div class="col-lg-5">
                <div key="0x" class="title">{{ $t('selling') }}</div>
                <feed-selling :user="user" @set-posts="setPosts" />
                <div key="2x" class="title">{{ $t('sold') }}</div>
                <feed-sold :user="user"  @set-inactive-posts="setInactivePosts" />
            </div>
        </div>
    </div>
</template>
<script>
import feedPurchased from '~/components/feeds/Purchased.vue'
import feedSelling from '~/components/feeds/Selling.vue'
import feedSold from '~/components/feeds/Sold.vue'

export default {
    scrollToTop: false,
    components: { feedPurchased, feedSelling, feedSold },
    props: ['user'],
    metaInfo() {
        return { title: this.$t('your_textbooks') }
    },

    computed: {},

    data: () => ({
        posts: [],
        inactivePosts: []
    }),

    created() {},

    methods: {
        setPosts(value) {
            this.posts = value
        },
        setInactivePosts(value) {
            this.inactivePosts = value
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

.sticky {
    position: sticky;
    position: -webkit-sticky;
    top: 65px;
    max-height: calc(100vh - 65px);
    overflow-x: scroll;
}
</style>