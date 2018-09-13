<template>
    <div>
        <card v-if="sortedBooks.length <= 0">
            <card-header :title="$t('join_your_university_community')+'!'" subtitle="Sign up now!">
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
import axios from 'axios'
import { mapGetters } from 'vuex'
import uniqBy from 'lodash/uniqBy'

export default {
    scrollToTop: true,
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
        this.getsuggested()
    },

    methods: {
        getusers() {
            this.loading = true
            var data = this

            axios('/api/v1/books?university=' + this.$route.params.id).then(function(response) {
                data.page++
                data.loading = false
                data.left = response.data.total - (response.data.per_page * response.data.current_page)
                $.each(response.data.data, function(res, val) {
                    data.books.push(val)
                })
            })
        },
        getsuggested() {
            var data = this
            axios('/api/v1/suggestions/university-books/' + this.$route.params.id).then(function(response) {
                $.each(response.data.data, function(res, val) {
                    data.books.push(val)
                })
            })
        }
    }

}
</script>