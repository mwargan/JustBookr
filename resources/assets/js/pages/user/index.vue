<template>
    <div>
        <page-header v-if="user" :title="fullName" :subtitle="subtitle" :subtext="subtext" :image="user.profilepic">
        </page-header>
        <div class="row">
            <ul class="nav nav-pills" style="margin-bottom:1rem;">
                <li v-for="tab in tabs" class="nav-item">
                    <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
                        <fa :icon="tab.icon" fixed-width/> {{ tab.name }}
                    </router-link>
                </li>
            </ul>
        </div>
        <keep-alive>
            <router-view :user="user"></router-view>
        </keep-alive>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import store from '~/store'
import router from '~/router'

export default {

    metaInfo() {
        return {
            title: this.user.name,
            meta: [
                { name: 'description', content: `Student at ${this.user.university['uni-name']} on JustBookr`, vmid: 'description' }, { property: 'og:image', content: this.user.profilepic, vmid: 'og:image' }
            ]
        }
    },

    data: () => ({
        page: 1,
        loading: false
    }),
    beforeRouteEnter(to, from, next) {
        store.dispatch('user/fetchUser', to.params.id).then(response => {
            // the above state is not available here, since it
            next()
        }, error => {
            next('/404')
        })
    },
    computed: {
        tabs() {
            return [

                {
                    icon: "book",
                    name: this.$t('textbooks'),
                    route: 'user.textbooks'
                }
            ]
        },
        ...mapGetters({
            me: 'auth/user',
            allUsers: 'user/users',
            thisUser: 'user/getUserById'
        }),
        user() {
            return this.thisUser(this.$route.params.id)
        },
        fullName() {
            return this.user.name
        },
        subtitle() {
            if (this.user.university)
                return this.$t("at") + " <a href='/university/" + this.user.university['uni-id'] + "'>" + this.user.university['uni-name'] + "</a>"
        },
        subtext() {
            if (this.user.positive_ratings) {
                return this.user.positive_ratings + " " + this.$t('positive_ratings').toLowerCase()
            }
        },
        sold() {
            return this.user.posts_count - this.user.active_posts_count
        }
    },
    mounted() {
        if (this.me && this.$route.params.id == this.me['user-id']) {
            router.replace('/your-textbooks')
        }
    },
    methods: {

        handleScroll() {

            if (((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 1300) && this.loading === false) {
                this.getPosts()
            }
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