<template>
    <div>
        <div class="p-3 row bg-primary text-white" style="min-height: 275px;margin-top: -1.5rem !important;">
            <div class="col-12 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    About JustBookr
                </h1>
                <h5 class="mb-4">
                    Learn about JustBookr
                </h5>
            </div>
        </div>
        <div class="p-3 row mt-5 mb-5" style="min-height: 275px;display: none;">
            <!--  <h1 class="display-4 pb-4 text-center mx-auto mt-auto mb-auto w-100">
                    Tailored to your business
                </h1> -->
            <div class="col-md-4 text-center align-self-center">
                <h3 class="display-5 mb-4 mx-auto mt-auto mb-auto">
                    On campus sellers
                </h3>
                <p>
                    Reach students on university campuses you sell at, when they're actively looking for textbooks, right here on JustBookr.
                    <small class="text-muted d-block">€19.57 per stand per month</small>
                </p>
            </div>
            <div class="col-md-4 text-center align-self-center">
                <h3 class="display-5 mb-4 mx-auto mt-auto mb-auto">
                    Local bookstores
                </h3>
                <p>
                    Promote your off-campus brick and mortar bookstore to local university students around your place of business.
                    <small class="text-muted d-block">Coming soon</small>
                </p>
            </div>
            <div class="col-md-4 text-center align-self-center">
                <h3 class="display-5 mb-4 mx-auto mt-auto mb-auto">
                    Online retailers
                </h3>
                <p>
                    Offer <i>Delivered to your door</i> services to students in over 22,000 universities across more than 170 countries.
                    <small class="text-muted d-block">Contact us</small>
                </p>
            </div>
        </div>
        <div class="p-3 row mt-5 mb-5" style="min-height: 275px;">
            <div class="col-md-6 text-center align-self-center">
                <img class="responsive" src="/images/icons/custom/business/post.svg" style="max-height: 300px;">
            </div>
            <div class="col-md-6 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Post books for sale
                </h1>
                <p>
                    Where to sell student textbooks? Right here! JustBookr lets you post your old textbooks for sale on your university canpus so that other students can buy them. It's simple, and only face to face do money and textbook exchange!
                    <div class="d-block">
                    <router-link class="btn btn-primary" to="/sell">Post a textbook for sale</router-link>
                </div>
                </p>
            </div>
        </div>
        <div class="p-3 row mt-5 mb-5" style="min-height: 275px;">
            <div class="col-md-6 text-center align-self-center order-md-2">
                <img class="responsive" src="/images/icons/custom/business/orders.svg" style="max-height: 300px;">
            </div>
            <div class="col-md-6 text-center align-self-center order-md-1">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Find cheaper offers
                </h1>
                <p>
                    The whole power with JustBookr comes from the fact that it's always been and always will be for one purpose only - to allow students to trade their second hand textbooks. This means that the whole site is made so that you can do just that, faster and easier.
                </p>
                <div class="d-block">
                    <router-link class="btn btn-primary" to="/discover">Find books sold on campus</router-link>
                </div>
            </div>
        </div>
        <div class="p-3 row mt-5 mb-5" style="min-height: 275px;">
            <div class="col-md-6 text-center align-self-center order-md-2">
                <img class="responsive" src="/images/icons/custom/business/pie-chart.svg" style="max-height: 300px;">
            </div>
            <div class="col-md-6 text-center align-self-center order-md-1">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Understand demand
                </h1>
                <p>
                    Choose what books to promote based on whats popular now at specific universities.
                </p>
            </div>
        </div>
        <div class="p-3 row mt-5 mb-5" style="min-height: 275px;">
            <div class="col-md-6 text-center align-self-center ">
                <img class="responsive" src="/images/icons/custom/business/line-graph.svg" style="max-height: 300px;">
            </div>
            <div class="col-md-6 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Sell more
                </h1>
                <p>
                    Reach highly specific audiences you target, at the exact moment they are looking to make a purchase.
                </p>
            </div>
        </div>
        <div class="p-3 row mt-5 mb-5" style="min-height: 275px;display: none;">
            <div class="col-md-6 text-center align-self-center">
                <img class="responsive" src="/images/icons/custom/business/books-inventory.svg" style="max-height: 300px;">
            </div>
            <div class="col-md-6 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Track inventory
                </h1>
                <p>
                    Coming soon!
                </p>
            </div>
        </div>
        <div class="p-3 row bg-primary text-white" style="min-height: 275px;">
            <div class="col-12 text-center align-self-center">
                <div class="d-block mb-4 mt-4">
                    <router-link class="btn btn-light" to="/business/create">Create your business for free</router-link>
                </div>
                <h2 class="display-5 mb-4 mx-auto mt-auto mb-auto">
                    Be where the students are
                </h2>
                <h5>
                    Start today with JustBookr for Business
                </h5>
            </div>
        </div>
    </div>
</template>
<script>
import API from '~/api/general'
import { mapGetters } from 'vuex'

export default {
    layout: 'app',

    metaInfo() {
        return { title: this.$t('home') }
    },
    mounted() {
        this.getSuggested()
        this.getUniversities()
    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/check'
        }),
        tabs() {
            return [{
                    icon: "user",
                    name: this.$t('students'),
                    route: 'data.users'
                },
                {
                    icon: "post",
                    name: this.$t('posts'),
                    route: 'data.posts'
                },
                {
                    icon: "chart",
                    name: this.$t('stats'),
                    route: 'data.stats'
                }
            ]
        },
    },

    data: () => ({
        title: window.config.appName,
        loading: true,
        suggested: [],
        universities: []
    }),
    methods: {
        getSuggested() {
            this.loading = true
            var data = this
            API.index('suggestions/textbooks').then(function(response) {
                data.loading = false
                if (response.data.data.length > 0) {
                    API.parseResponseData(this, response.data.data, 'suggested')
                } else {
                    data.getRecent()
                }
            })
        },
        getRecent() {
            this.loading = true
            var data = this
            API.index('suggestions/recent').then(function(response) {
                data.loading = false
                API.parseResponseData(this, response.data.data, 'suggested')
            })
        },
        getUniversities() {
            this.loading = true
            var data = this
            API.index('universities', {
                'per_page': 8,
                'with_logo': true
            }).then(function(response) {
                data.loading = false
                API.parseResponseData(this, response.data.data, 'universities', 'university/addUniversity')
            })
        }
    }
}
</script>
<style scoped>

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