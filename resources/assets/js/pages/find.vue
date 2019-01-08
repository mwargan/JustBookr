<template>
    <div :title="$t('find')">
        <div class="title">{{ $t('textbooks') }}</div>
        <template v-if="!loading">
            <card v-show="sortedBooks && sortedBooks.length < 1 && !google_loading">
                <card-header :title="$t('we_couldnt_find_the_textbook_youre_looking_for')" subtitle="Tip: use the books ISBN-13 number for best results">
                </card-header>
                <card-content>
                    <div id="suggested" class="scroller" v-if="suggested">
                        <div class="content-block-title" style="text-transform: none;white-space:normal;text-overflow:initial;overflow:visible;">{{ $t('recently_looked_at') }}</div>
                        <router-link v-for="book in recent" :key="book.isbn" :to="{ name: 'textbook.posts', params: {isbn: book.isbn } }" onclick="ga('send', 'event', 'Link', 'Click', 'Book suggestion - recently viewed');" class="image-link">
                            <img class="image_fade" itemprop="image" v-lazy="book['image-url']" onerror="this.src='/images/image_error.svg'" alt="A picture of Essentials of Negotiation, on JustBookr.">
                        </router-link>
                        <div class="content-block-title" style="margin-left:5rem;text-transform: none;white-space:normal;text-overflow:initial;overflow:visible;">{{ $t('semester_suggestions') }}</div>
                        <transition-group name="fade" mode="out-in">
                            <router-link v-for="book in suggested" :key="book.isbn" :to="{ name: 'textbook.posts', params: {isbn: book.isbn } }" onclick="ga('send', 'event', 'Link', 'Click', 'Book suggestion - semester suggestion');" class="image-link">
                                <img class="image_fade" itemprop="image" onerror="this.src='/images/image_error.svg'" v-lazy="book['image-url']" alt="A picture of Essentials of Negotiation, on JustBookr.">
                            </router-link>
                        </transition-group>
                        <div class="content-block-title" style="margin-left:3rem;text-transform: none;white-space:normal;text-overflow:initial;overflow:visible;">{{ $t('search_to_see_more') }}</div>
                    </div>
                </card-content>
            </card>
            <card v-for="(post, index) in sortedBooks" :key="'book_'+post.isbn">
                <card-content>
                    <card-content-book :title="post['book-title']" :subtitle="post['author']" :image="post['image-url']" :text="post.isGoogle ? $t('prefilled_by_google_books') : post['edition']" :isbn="post.isbn"></card-content-book>
                </card-content>
            </card>
            <card v-show="sortedBooks.length > 0">
                <card-header icon="info" title="Try finding books using their ISBN-13, title, or author" subtitle="You can find universities too!">
                </card-header>
            </card>
        </template>
        <transition name="fade">
            <card-placeholder v-if="loading || google_loading"></card-placeholder>
        </transition>
        <template v-if="!loading">
            <div class="title" v-show="results.users && results.users.length > 0">{{ $t('students') }}</div>
            <card v-for="(post, index) in results.users" :key="'user_'+post['user-id']">
                <card-header :link="'/user/'+post['user-id']" :title="post['name']" :subtitle="university[index]" :image="post['profilepic']">
                </card-header>
            </card>
            <div class="title" v-show="results.universities && results.universities.length > 0">{{ $t('universities') }}</div>
            <card v-for="(post, index) in results.universities" :key="'uni_'+post['uni-id']">
                <card-header :link="'/university/'+post['uni-id']" :title="post['uni-name']" :subtitle="post.country.name" :image="post['uni-logo']" image-shape="square">
                </card-header>
            </card>
        </template>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import uniqBy from 'lodash/uniqBy'
import VueFuse from 'vue-fuse'

export default {
    metaInfo() {
        return { title: this.$t('find') }
    },
    data: () => ({
        suggested: [],
        recent: [],
        results: [
            books => [],
            universities => [],
            users => []
        ],
        loading: true,
        google_loading: false
    }),
    beforeRouteUpdate(to, from, next) {
        if (to.params.query) {
            this.search(to.params.query)
        }
        next()
    },
    created() {
        if (this.$route.params.query) {
            this.search(this.$route.params.query)
        } else {
            this.loading = false
        }
        this.getSuggested()
        this.getRecent()
    },

    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
        subtitle() {
            return this.results.books.map((item) => {
                if (item.top_post) {
                    var price = `${item.top_post.university.country.currency}${item.top_post.price}`
                    return `${this.$t('selling')} <i>${ item['book-title'] }</i> ${this.$t('for').toLowerCase()} ${price}`
                }
            })
        },
        university() {
            return this.results.users.map((item) => {
                if (item.university) {
                    return item.university['uni-name']
                }
            })
        },
        sortedBooks() {
            return uniqBy(this.results.books, 'isbn')

        }
    },

    methods: {
        getSuggested() {
            var data = this
            axios('/api/v1/suggestions/textbooks').then(function(response) {
                $.each(response.data.data, function(res, val) {
                    data.suggested.push(val)
                    data.$store.dispatch('book/addBook', val)
                })
            })
        },
        getRecent() {
            var data = this
            axios('/api/v1/suggestions/recent').then(function(response) {
                $.each(response.data.data, function(res, val) {
                    data.recent.push(val)
                    data.$store.dispatch('book/addBook', val)
                })
            })
        },
        async search(query) {
            this.loading = true
            var data = this
            var uni = ""
            if (this.user && this.user['uni-id']) {
                uni = "?university=" + (this.user['uni-id'])
            }
            await axios('/api/v1/books/search/' + query + uni).then(function(response) {
                data.$set(data.results, 'books', response.data.data)
                $.each(response.data.data, function(res, val) {
                    data.$store.dispatch('book/addBook', val)
                })
            })
            if (this.results.books.length < 8) {
                this.google_loading = true
                this.getGoogleBooks(query)
            } else {
                this.searchLocally(query, true)
            }
            this.searchUniversities(query)
            this.searchUsers(query)
        },
        async getGoogleBooks(query) {
            await axios('/api/v1/search/books/' + query + '/google').then(response => {
                var result = response.data
                if (result && result.length > 0) {
                    $.each(result, (res, val) => {
                        if (val) {
                            this.results.books.push(val)
                            this.$store.dispatch('book/addBook', val)
                        }
                    })
                }
                this.searchLocally(query)
                this.google_loading = false
            })
        },
        async searchUniversities(query) {
            var data = this
            await axios('/api/v1/universities/search/' + query).then(function(response) {
                data.$set(data.results, 'universities', response.data.data)
                $.each(response.data.data, function(res, val) {
                    data.$store.dispatch('university/addUniversity', val)
                })

            })
        },
        async searchUsers(query) {
            var data = this
            await axios('/api/v1/users/search/' + query).then(function(response) {
                data.$set(data.results, 'users', response.data.data)
                $.each(response.data.data, function(res, val) {
                    data.$store.dispatch('user/addUser', val)
                })

            })
        },
        async saveResult(query) {
            var data = {}
            data.query = query
            data.results_count = this.results.books.length
            await axios.post('/api/v1/searches', data)
        },
        searchLocally(query, direct = false) {
             var options = {
                    shouldSort: true,
                    tokenize: true,
                    findAllMatches: true,
                    threshold: 0.6,
                    location: 0,
                    distance: 70,
                    maxPatternLength: 32,
                    minMatchCharLength: 1,
                    keys: [
                        "isbn", "book-title", "edition"
                    ]
                }
                this.$search(query, this.results.books, options).then(results => {
                    this.results.books = results
                    if(direct && this.results.books.length < 5) {
                        this.getGoogleBooks(query)
                    } else {
                        this.loading = false
                        this.saveResult(query)
                    }
                })
        }
    }
}
</script>
<style scoped>
/*! CSS Used from: /css/normalize.css */

a {
    background-color: transparent;
}

a:active,
a:hover {
    outline: 0;
}

img {
    border: 0;
}


/*! CSS Used from: /css/skeleton.css */

a {
    text-decoration: none;
    color: #244572;
}

a:hover {
    color: #3c74bf;
}




/*! CSS Used from: /css/main.css */


/*! @import https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css */


/*! CSS Used from: https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css */


/*! end @import */

a {
    -webkit-transition: all .15s ease-in-out 0s;
    transition: all .15s ease-in-out 0s;
}

img {
    display: block;
    image-rendering: crisp-edges;
    image-rendering: -moz-crisp-edges;
}

.clear-menu {
    margin-top: calc(1rem + 45px);
}

.content-block-title {
    font-size: 1.5rem;
    line-height: 1;
    position: relative;
    overflow: hidden;
    margin: 0 auto;
    padding: 1rem;
    text-align: center;
    white-space: nowrap;
    text-transform: uppercase;
    text-overflow: ellipsis;
    color: #8e8e93;
}





/*! CSS Used from: Embedded */

.scroller {
    overflow-x: visible;
    display: flex;
    overflow-y: hidden;
    width: 100%;
    width: calc(100% + 20px);
    margin-left: -10px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    align-items: center;
}

.scroller>span {
    display: flex;
}

.scroller div.content-block-title {
    font-weight: 700;
    font-size: 36px;
    color: #4A4A4A;
    letter-spacing: 0;
    text-align: right!important;
}

.facebook-card .card-content .scroller img {
    max-width: 150px;
}

.scroller img.image_fade {
    box-shadow: 0 3px 25px 0 rgba(0, 0, 0, 0.15);
    width: 200px;
    height: 270px;
    float: left;
    display: block;
    margin: 1.3rem;
    background-color: #fff;
    object-fit: cover;
    border-radius: 5px;
    border: 1px solid #aaaaaa;
    -webkit-transition: .20s ease all;
    transition: .20s ease all;
}

.scroller img.image_fade:hover {
    transform: scale(1.01);
}

.title {
    max-width: 700px;
    margin: 0 auto;
    color: #b3b3b3;
    font-size: 2rem;
}
</style>