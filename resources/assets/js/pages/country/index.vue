<template>
    <div>
        <page-header :title="country.name" :image="'/images/flags/'+$route.params.iso.toLowerCase()+'.svg'" />
<!--         <div>{{country}}</div>
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
                <router-view :country="country"></router-view>
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
        return {
            title: this.country.name + ' ' + this.$t('universities'),
            meta: [
                { name: 'description', content: "Find universities in "+this.country.name+" where you can trade textbooks on campus with fellow students on JustBookr!", vmid: 'description' },
            ]
        }
    },

    data: () => ({
        page: 1,
        country: {},
        loading: false
    }),
    beforeRouteEnter(to, from, next) {
        axios('/api/v1/countries/' +  to.params.iso).then(response => {
            // the above state is not available here, since it
            next(vm => {
                vm.country = response.data
            })
        }, error => {
            next('/404')
        })
    },
    beforeRouteUpdate(to, from, next) {
        axios('/api/v1/countries/' +  to.params.iso).then(response => {
            // the above state is not available here, since it
            next(vm => {
                vm.country = response.data
            })
        }, error => {
            next('/404')
        })
    },
    computed: {
        tabs() {
            return [{
                    icon: "users",
                    name: this.$t('universities'),
                    route: 'country.universities'
                },
                {
                    icon: "info",
                    name: this.$t('info'),
                    route: 'country.info'
                }
            ]
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