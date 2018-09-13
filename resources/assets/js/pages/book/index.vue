<template>
    <div>
        <page-header :title="book['book-title']" :subtitle="book.author" :subtext="subtext" :image="book['image-url']"></page-header>
<!--         <div>{{book}}</div>
 -->        <div class="row">
            <ul class="nav nav-pills mb-2">
                <li v-for="tab in tabs" class="nav-item">
                    <router-link :to="{ name: tab.route, params: tab.params }" class="nav-link" active-class="active">
                        {{ tab.name }}
                    </router-link>
                </li>
            </ul>
        </div>
        <transition name="fade">
            <keep-alive>
                <router-view :book="book" :user="user"></router-view>
            </keep-alive>
        </transition>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import store from '~/store'

export default {

    metaInfo() {
        return { title: this.thisBook['book-title'], meta: [
                { name: 'description', content: this.book['book-des'], vmid: 'description' },
                { property: 'og:image', content: this.book['image-url'], vmid: 'og:image' }
            ] }
    },

    data: () => ({
        page: 1,
        loading: false
    }),
    beforeRouteEnter(to, from, next) {
        store.dispatch('book/fetchBook', to.params.isbn).then(response => {
            // the above state is not available here, since it
            next()
        }, error => {
            next('/404')
        })
    },
    beforeRouteUpdate(to, from, next) {
         store.dispatch('book/fetchBook', to.params.isbn).then(response => {
            // the above state is not available here, since it
            next()
        }, error => {
            next('/404')
        })
    },
    computed: {
        tabs() {
            return [{
                    icon: "users",
                    name: this.$t('posts'),
                    route: 'textbook.posts'
                },
                {
                    icon: "info",
                    name: this.$t('info'),
                    route: 'textbook.info'
                },
                {
                    icon: "info",
                    name: this.$t('sell_a_copy'),
                    route: 'sell',
                    params: { isbn: this.$route.params.isbn }
                }
            ]
        },
        subtext() {
            if (this.book.isGoogle) {
                return "<a target='_BLANK' href='"+this.book.googleLink+"'>"+this.$t('prefilled_by_google_books')+"</a>"
            }
            else if (this.book.edition) {
                return this.book.edition + " " + this.$t('edition').toLowerCase()
            }
        },
        ...mapGetters({
            thisBook: 'book/getBookByIsbn',
            user: 'auth/user'
        }),
        book() {
            return this.thisBook(this.$route.params.isbn)
        }
    }
}
</script>
<style scoped>
.nav-item {
    margin: 0 auto;
}

.nav {
    width: 100%;
}

.nav-link {
    border-radius: 1rem;
    border: none;
}
</style>