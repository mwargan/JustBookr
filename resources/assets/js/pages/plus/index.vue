<template>
    <div>
        <div class="p-3 row bg-primary text-white" style="min-height: 275px;margin-top: -1.5rem !important;">
            <div class="col-12 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Cheaper books at your door
                </h1>
                <h5 class="mb-4">
                    JustBookr+
                </h5>
                <div class="d-block">
                    <router-link class="btn btn-light" to="/sell">Coming soon</router-link>
                </div>
            </div>
        </div>
        <div class="p-3 row mt-5 mb-5" style="min-height: 275px;">
            <div class="col-md-6 text-center align-self-center">
                <img class="responsive" src="data:image/png;base64,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">
            </div>
            <div class="col-md-6 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Free shipping
                </h1>
                <p>
                    Pay nothing for delivery of all the textbooks you order with JustBookr+.
                </p>
            </div>
        </div>
        <div class="p-3 row mt-5 mb-5" style="min-height: 275px;">
            <div class="col-md-6 text-center align-self-center order-md-2">
                 <img class="responsive" src="data:image/png;base64,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">
            </div>
            <div class="col-md-6 text-center align-self-center order-md-1">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    2-5 day delivery
                </h1>
                <p>
                Start flipping through pages in your new book in 2 days. Sometimes 5.
                </p>
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
            return [
                {
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
                if(response.data.data.length > 0) {
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