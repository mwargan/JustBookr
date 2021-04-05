<template>
    <div>
        <card v-if="sortedBooks.length <= 0">
            <card-header :title="$t('join_your_university_community')+'!'" link="/sign-up" subtitle="Sign up now!">
            </card-header>
        </card>
        <transition-group name="fade" mode="out-in">
            <card v-for="(post, index) in sortedBooks" :key="'book_'+post.isbn">
                <card-content>
                    <card-content-book :title="post['book-title']" :subtitle="post['author']" :image="post['image-url']" :text="post['edition']" :isbn="post.isbn"></card-content-book>
                </card-content>
            </card>
        </transition-group>
        <card-placeholder v-if="loading"></card-placeholder>
        <card v-if="left > 0">
            <card-header :title="'+ '+left+' '+$t('others').toLowerCase()"></card-header>
        </card>
    </div>
</template>
<script>
import API from '~/api/general'
import { mapGetters } from 'vuex'
import uniqBy from 'lodash/uniqBy'
import addBookMixin from '~/mixins/addBookMixin'

export default {
    scrollToTop: true,
    mixins: [addBookMixin],
    props: ['university'],
    metaInfo() {
        return { title: this.university['uni-name']+' '+this.$t('students') }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
        sortedBooks () {
            return uniqBy(this.books, 'isbn')
        }
    },

    data: () => ({
        books: [],
        page: 1,
        left: 0,
        loading: false
    }),

    created() {
        this.getusers()
        this.getSuggestions('university-books/' + this.$route.params.id, 'books')
    },

    methods: {
        getusers() {
            this.loading = true
            API.index('books', {
                'university': this.$route.params.id
            }).then((response) => {
                this.page++
                this.loading = false
                this.left = response.data.total - (response.data.per_page * response.data.current_page)
                API.parseResponseData(this, response.data.data, 'books', false)
            })
        }
    }

}
</script>