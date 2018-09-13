<template>
    <div>
        <div class="p-3 row bg-primary text-white" style="min-height: 275px;margin-top: -1.5rem !important;">
            <div class="col-12 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    {{ $t('data_center') }}
                </h1>
                <h5 class="mb-4">
                    JustBookr
                </h5>
            </div>
        </div>
        <div class="row">
            <ul class="nav nav-pills nav-fill justify-content-center w-100" style="margin-bottom:1rem;">
                <li v-for="tab in tabs" class="nav-item">
                    <router-link :to="{ name: tab.route, params: tab.params }" class="nav-link" active-class="active">
                        {{ tab.name }}
                    </router-link>
                </li>
            </ul>
        </div>
        <transition name="fade">
            <router-view></router-view>
        </transition>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    layout: 'app',

    metaInfo() {
        return { title: this.$t('data_center') }
    },
    mounted() {
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
        loading: true
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