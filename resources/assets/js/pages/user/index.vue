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
        loading: false,
        time_to_reply: 0,
        sales: 0
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
            var text = ""
            if (this.sales > 3) {
                 text = text + '<img style="width:2.5rem;" src="https://img.icons8.com/bubbles/50/000000/elephant-circus.png"/> '+ this.$t('popular_seller')+ " <br/> "
            }
            if (this.time_to_reply <= 240 && this.time_to_reply > 1) {
                 text = text + '<img style="width:2.5rem;" src="https://img.icons8.com/bubbles/50/000000/skip-15-seconds-back.png"/> '+ this.$t('fast_at_replying')+ " <br/> "
            }
            if (this.$moment(this.user['user-registered'], 'X').format("YYYY") <= 2018) {
                 text = text + '<img style="width:2.5rem;" src="https://img.icons8.com/bubbles/50/000000/like.png"/> JustBookr '+ this.$t('supporter').toLowerCase()+ " <br/> "
            }
            if (this.user.points > 25) {
                 text = text + '<img style="width:2.5rem;" src="https://img.icons8.com/bubbles/50/000000/medal.png"/> '+ this.$t('pro_trader')+ " <br/> "
            }
            if (this.user.positive_ratings) {
                 text = text + '<img style="width:2.5rem;" src="https://img.icons8.com/bubbles/50/000000/facebook-like.png"/> ' + this.user.positive_ratings + " " + this.$t('positive_ratings').toLowerCase() + " <br/> "
            }
            text = text + "<small>"+this.$t('member_since')+" "+this.$moment(this.user['user-registered'], 'X').format("MMMM YYYY")+"</small>"
            return text
        },
        sold() {
            return this.user.posts_count - this.user.active_posts_count
        }
    },
    mounted() {
        if (this.me && this.$route.params.id == this.me['user-id']) {
            router.replace('/your-textbooks')
        }
        this.getTimeToReply()
    },
    methods: {

        handleScroll() {

            if (((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 1300) && this.loading === false) {
                this.getPosts()
            }
        },
        getTimeToReply() {
            axios('/api/v1/users/'+this.user['user-id']+'/time-to-reply').then(data => {
                if(data.data.time_to_reply && data.data.count_of_sales > 1) {
                    this.time_to_reply = int(data.data.time_to_reply);
                    this.sales = int(data.data.count_of_sales);
                    return
                }
            });
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