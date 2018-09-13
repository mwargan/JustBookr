<template>
    <div>
        <div class="row">
            <div class="col-lg-8">
                <div key="1x" class="title">{{ $t('bought') }}</div>
                <feed-purchased :user="user" :posts="posts" />
            </div>
            <div class="col-lg-4">
                <div key="0x" class="title">{{ $t('selling') }}</div>
                <feed-selling :user="user" @set-posts="setPosts" />
            </div>
        </div>
    </div>
</template>
<script>
import feedPurchased from '~/components/feeds/Purchased.vue'
import feedSelling from '~/components/feeds/Selling.vue'

export default {
    scrollToTop: false,
    components: { feedPurchased, feedSelling },
    props: ['user'],
    metaInfo() {
        return { title: this.$t('your_textbooks') }
    },

    computed: {},

    data: () => ({
        posts: []
    }),

    created() {},

    methods: {
        setPosts(value) {
            this.posts = value
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