<template>
    <div>
        <div class="p-3 row bg-primary text-white mb-3" style="min-height: 175px;margin-top: -1.5rem !important;">
            <div class="col-12 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Your Businesses
                </h1>
                <h5 class="mb-4">
                    JustBookr for Business
                </h5>
            </div>
        </div>
            <card v-for="(business, index) in businesses" :key="'business_'+business.id">
                <card-content>
                    <card-content-book :title="business.name" :image="business.logo" :text="(business.stands.length > 0 ? business.stands.length : '0')+' active stands'" :link="'/business/admin/'+business.id+'/stands'"></card-content-book>
                </card-content>
            </card>
            <card>
                <card-header :title="$t('create_a_new_business')" icon="plus" link="/business/create">
                </card-header>
            </card>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import store from '~/store'

export default {
    layout: 'app',

    metaInfo() {
        return { title: this.$t('home') }
    },
    mounted() {
    },
    computed: {
         ...mapGetters({
            authenticated: 'auth/check'
        })
    },
    beforeRouteEnter(to, from, next) {
            axios.get('/api/v1/businesses?paginate=false&user='+store.getters['auth/user']['user-id']).then(response => {
            next(vm => {
                           vm.businesses = response.data
                           //vm.stand = response.data
                       })
            }, error => {
                // handle error here
            })
    },
    data: () => ({
        title: window.config.appName,
        businesses: []
    }),
        methods: {

        }
}
</script>
<style scoped>
a.btn-primary {
    border-radius: 5px;
    height: 30px;
    line-height: 30px;
    color: white;
}

.top-right {
    position: absolute;
    right: 10px;
    top: 18px;
}

.title {
    font-size: 75px;
}

.img-thumbnail {
    height: 200px;
    object-fit: scale-down;
}

.light {
    font-weight: 200;
}
</style>