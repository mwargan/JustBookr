<template>
    <div>
        <card>
            <card-header :title="fullName" subtitle="subtitle(post)" :image="post.user.profilepic">
            </card-header>
            <card-content :text="post['post-description']">
                <card-content-book :title="post.textbook['book-title']" :subtitle="post.textbook['author']" :image="post.textbook['image-url']" :text="post.textbook['edition']" :isbn="post.isbn"></card-content-book>
            </card-content>
            <card-footer></card-footer>
        </card>
            <form action="index_submit" method="get" accept-charset="utf-8">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">ISBN-13</label>
                    <div class="col-md-7">
                        <input placeholder="Your comment" type="text" name="isbn" class="form-control">
                    </div>
                </div>
            </form>
        <card>
            <card v-for="post in post.post_comments" class="comment">
                <card-header :title="post.user.name+': '+post.comment" :subtitle="post.comment_timestamp" :image="post.user.profilepic">
                </card-header>
            </card>
        </card>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import store from '~/store'

export default {
    scrollToTop: false,

    metaInfo() {
        return { title: this.$t('post') }
    },

    data: () => ({
        page: 1,
        loading: false
    }),
    beforeRouteEnter(to, from, next) {
        store.dispatch('post/fetchPost', to.params.id).then(response => {
            // the above state is not available here, since it
            next()
        }, error => {
            // handle error here
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
                }
            ]
        },
        fullName() {
            return this.post.user.name
        },
        subtext() {
            if (this.book.edition) {
                return this.book.edition + " " + this.$t('edition').toLowerCase()
            }
        },
        ...mapGetters({
            user: 'auth/user',
            allBooks: 'post/posts',
            thisBook: 'post/getPostById'
        }),
        post() {
            return this.thisBook(this.$route.params.id)
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

.comment {
    width: 96%;
    border: 0;
    border-radius: 0;
}
</style>