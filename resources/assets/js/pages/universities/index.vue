<template>
    <div>
        <page-header v-if="university" :title="university['uni-name']" :subtext="university.abr" :subtitle="university.country.name" :image="university['uni-logo']" :subtitle-link="'/country/'+university.country.iso2"></page-header>

        <div class="row">
            <ul class="nav nav-pills" style="margin-bottom:1rem;">
                <li v-for="tab in tabs" class="nav-item">
                    <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
                        <fa :icon="tab.icon" fixed-width/> {{ tab.name }}
                    </router-link>
                </li>
            </ul>
        </div>
        <transition name="fade">
            <keep-alive>
                <router-view :university="university"></router-view>
            </keep-alive>
        </transition>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import store from '~/store'

export default {
    scrollToTop: true,
    metaInfo() {
        return { title: this.university['uni-name'], meta: [
                { name: 'description', content: `University in ${this.university.country.name} on JustBookr`, vmid: 'description' },
                { property: 'og:image', content: this.university['uni-logo'], vmid: 'og:image' }
            ] }
    },

    data: () => ({
        page: 1,
        loading: false
    }),
    beforeRouteEnter(to, from, next) {
        store.dispatch('university/fetchUniversity', to.params.id).then(response => {
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
                    route: 'universities.textbooks'
                },
                {
                    icon: "users",
                    name: this.$t('students'),
                    route: 'universities.users'
                },
                {
                    icon: "info",
                    name: this.$t('info'),
                    route: 'universities.info'
                }
            ]
        },
        ...mapGetters({
            user: 'auth/user',
            allUniversities: 'university/universities',
            thisUniversity: 'university/getUniversityById'
        }),
        university() {
            return this.thisUniversity(this.$route.params.id)
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