<template>
    <div>
        <page-header v-if="business" :title="business.name" subtext="Business" subtitle="" :image="business.logo"></page-header>
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
                <router-view :business="business"></router-view>
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
        return { title: this.business.name, meta: [
                { name: 'description', content: this.business.name+` is a business selling textbooks on JustBookr`, vmid: 'description' },
                { property: 'og:image', content: this.business.logo, vmid: 'og:image' }
            ] }
    },

    data: () => ({
        page: 1,
        loading: false,
        business: {},
        business2: { id: 1,
        stands: [{
            id:1,
            stand_text: "We're here again at the cafeteria selling books for you! And this time we accept credit cards!",
            university:{
                uni_id:1,
                uni_name:"International University of Monaco"
            },
            nearest_open_date:1528654084,
            nearest_close_date:1528854889,
            location:"At the cafeteria"
        },
        {
            id:2,
            stand_text: "We're here again at the cafeteria selling books for you! And this time we accept credit cards!",
            university:{
                uni_id:3,
                uni_name:"Erasmus College"
            },
            nearest_open_date:1528854989,
            nearest_close_date:1528864989,
            location:"At the library"
        },
        {
            id:3,
            stand_text: "We're here again at the cafeteria selling books for you! And this time we accept credit cards!",
            university:{
                uni_id:3,
                uni_name:"Great College"
            },
            nearest_open_date:1538854989,
            nearest_close_date:1548864989,
            location:"In room E114"
        }],
        name: "DeWalt Books", description: "The Bookstore is located in the heart of the McMaster campus in Westdale, ... o'clock the night before your final exam we will have a copy of the textbook in stock.", website: "https://image.freepik.com/free-vector/x-letter-stripe-on-sphere-ball-or-circle-corporate-generic-logo-template_8580-28.jpg" }
    }),
    beforeRouteEnter(to, from, next) {
        axios.get('/api/v1/businesses/'+to.params.id).then(response => {
            next(vm => {
                           vm.business = response.data
                       })
        }, error => {
            // handle error here
        })
    },
    mounted() {
            // axios.get('/api/v1/businesses/'+this.$route.params.id).then(response => {
            //     this.business = response.data
            // })
        },
    computed: {
        tabs() {
            return [
                // {
                //     icon: "book",
                //     name: this.$t('stands'),
                //     route: 'businesses.stands'
                // },
                {
                    icon: "info",
                    name: this.$t('info'),
                    route: 'businesses.info'
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
        },
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