<template>
    <div>
        <div class="p-3 row bg-primary text-white" style="min-height: 275px;margin-top: -1.5rem !important;">
            <div class="col-12 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Sell more books
                </h1>
                <h5 class="mb-4">
                    JustBookr for Business
                </h5>
                <div class="d-block">
                    <router-link class="btn btn-light" to="/business/create">Create your business for free</router-link>
                </div>
            </div>
        </div>
        <div class="p-3 row mt-5 mb-5" style="min-height: 275px;">
            <!--  <h1 class="display-4 pb-4 text-center mx-auto mt-auto mb-auto w-100">
                    Tailored to your business
                </h1> -->
            <div class="col-md-4 text-center align-self-center">
                <h3 class="display-5 mb-4 mx-auto mt-auto mb-auto">
                    On campus sellers
                </h3>
                <p class="mb-1">
                    Reach students on university campuses you sell at, when they're actively looking for textbooks, right here on JustBookr.
                    <small class="text-muted d-block">€19.57 per stand per month</small>
                </p>
                <div class="d-block">
                    <router-link class="btn btn-primary mb-3" to="/business/create">Create a stand</router-link>
                </div>
            </div>
            <div class="col-md-4 text-center align-self-center">
                <h3 class="display-5 mb-4 mx-auto mt-auto mb-auto">
                    Local bookstores
                </h3>
                <p class="mb-1">
                    Promote your off-campus brick and mortar bookstore to local university students around your place of business.
                    <small class="text-muted d-block">Contact us upon creating your business on JustBookr</small>
                </p>
                <div class="d-block">
                    <router-link class="btn btn-primary mb-3" to="/business/create">Register your bookstore</router-link>
                </div>
            </div>
            <div class="col-md-4 text-center align-self-center">
                <h3 class="display-5 mb-4 mx-auto mt-auto mb-auto">
                    Online retailers
                </h3>
                <p class="mb-1">
                    Offer <i>Delivered to your door</i> services to students in over 22,000 universities across more than 170 countries.
                    <small class="text-muted d-block">Contact us upon creating your business on JustBookr</small>
                </p>
                <div class="d-block">
                    <router-link class="btn btn-primary mb-3" to="/business/create">Connect your website</router-link>
                </div>
            </div>
        </div>
        <div class="p-3 row mt-5 mb-5" style="min-height: 275px;">
            <div class="col-md-6 text-center align-self-center">
                <img class="responsive" src="/images/icons/custom/business/post.svg" style="max-height: 300px;">
            </div>
            <div class="col-md-6 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    List your books online
                </h1>
                <p>
                    Show your offers to +4k students a month, every day of the week, 24 hours a day. Reach millions more with your free shareable business page.
                </p>
                <div class="d-block">
                    <router-link class="btn btn-primary mb-3" to="/business/create">Post books online</router-link>
                </div>
            </div>
        </div>
        <div class="p-3 row mt-5 mb-5" style="min-height: 275px;display: none;">
            <div class="col-md-6 text-center align-self-center order-md-2">
                <img class="responsive" src="/images/icons/custom/business/orders.svg" style="max-height: 300px;">
            </div>
            <div class="col-md-6 text-center align-self-center order-md-1">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Manage reservations
                </h1>
                <p>
                    See when someone is coming to your stand to pick up a book from you.
                </p>
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
                <div class="d-block">
                    <router-link class="btn btn-primary mb-3" to="/business/create">Discover popular books</router-link>
                </div>
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
                <div class="d-block">
                    <router-link class="btn btn-primary mb-3" to="/business/create">Create your business</router-link>
                </div>
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
import axios from 'axios'
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
            axios('/api/v1/suggestions/textbooks').then(function(response) {
                data.loading = false
                if (response.data.data.length > 0) {
                    $.each(response.data.data, function(res, val) {
                        data.suggested.push(val)
                        data.$store.dispatch('book/addBook', val)
                    })
                } else {
                    data.getRecent()
                }
            })
        },
        getRecent() {
            this.loading = true
            var data = this
            axios('/api/v1/suggestions/recent').then(function(response) {
                data.loading = false
                $.each(response.data.data, function(res, val) {
                    data.suggested.push(val)
                    data.$store.dispatch('book/addBook', val)
                })
            })
        },
        getUniversities() {
            this.loading = true
            var data = this
            axios('/api/v1/universities?per_page=8&with_logo=true').then(function(response) {
                data.loading = false
                $.each(response.data.data, function(res, val) {
                    data.universities.push(val)
                    data.$store.dispatch('university/addUniversity', val)
                })
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