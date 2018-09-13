<template>
    <div>
        <div class="p-3 row bg-primary text-white" style="min-height: 275px;margin-top: -1.5rem !important;">
            <div class="col-12 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Learn about JustBookr
                </h1>
                <h5 class="mb-4">
                    JustBookr Help Center
                </h5>
            </div>
        </div>
        <transition name="fade">
            <keep-alive>
                <router-view :user="user"></router-view>
            </keep-alive>
        </transition>
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