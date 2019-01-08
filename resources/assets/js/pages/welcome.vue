<template>
    <div>
        <!-- <div class="p-3 row bg-primary text-white" style="background-image: url('/images/front_page_header.jpg');margin-top: -1.5rem;min-height: 275px;">
            <div class="col-12 text-center">
                <h1 class="display-4 mb-4 align-self-center mx-auto mt-auto mb-auto">
                    {{ title }}
                </h1>
                <h5 class="mb-4">
                    Trade textbooks at your university
                </h5>
            </div>
        </div> -->
        <div class="p-3 row bg-primary text-white mt-5" style="margin-top:-1.5rem !important;min-height: 275px;">
            <div class="col-12 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    {{ title }}
                </h1>
                <h5 class="mb-4">
                    {{ $t('trade_textbooks_at_your_university') }}
                </h5>
                <div v-if="authenticated" class="d-block">
                    <router-link class="btn text-white" to="/discover">{{ $t('find_textbooks') }}</router-link>
                    <router-link class="btn btn-success" to="/sell">{{ $t('sell_textbooks') }}</router-link>
                </div>
                <template v-else-if="facebook_app_id">
                    <div class="d-block">
                        <a href="/login/facebook" class="btn btn-dark ml-auto" style="background: rgb(59, 89, 152);border-color: rgb(59, 89, 152);">{{ $t('continue_with') }} <fa fixed-width :icon="['fab', 'facebook']"/></a>
                    </div>
                    <small class="d-block mt-3">{{ $t('its_free') }}!</small>
                </template>
                <template v-else>
                    <div class="d-block">
                        <router-link class="btn btn-success" to="/login">{{ $t('login') }}</router-link>
                    </div>
                    <small class="d-block mt-3">{{ $t('its_free') }}!</small>
                </template>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <h2 class="display-4">🔥 <span class="light">{{ $t('hot') }}</span> {{ $t('this_semester').toLowerCase() }}</h2>
                <p class="lead">
                    {{ $t('textbooks_being_traded_at_universities_right_now') }}
                </p>
            </div>
        </div>
        <div class="row w-95 mx-auto" style="max-width: 1080px;">
            <div class="col-md-3 col-sm-6 text-center mb-3" style="max-width: 50%;" v-for="(book, index) in sortedBooks" :key="book.isbn">
                <router-link :to="'/textbook/'+book.isbn">
                    <img class="img-thumbnail" v-lazy="book['image-url']" :alt="book['book-title']" onerror="this.src='/images/image_error.svg'" style="border:none;">
                    <small class="text-muted d-block">{{ $t('around') }} {{book.average_price}}</small>
                </router-link>
            </div>
        </div>
        <div class="row w-95 mx-auto" style="max-width: 1080px;" v-if="sortedBooks[0]">
           <div class="col-md-12 text-center align-self-center">
                <router-link class="mb-4 mx-auto mt-auto mb-auto btn btn-secondary" :to="'/find/978'">
                    +25 million titles
                </router-link>
            </div>
        </div>
        <div class="row w-95 mx-auto mb-5 mt-5" style="min-height: 275px;">
            <div class="col-md-6 text-center align-self-center">
                <img class="responsive" src="/images/icons/custom/business/book.svg" alt="Book to buy at university" style="max-height: 300px;">
            </div>
            <div class="col-md-6 text-center align-self-center">
                <h2 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Find cheaper textbooks
                </h2>
                <p>
                    The whole power with JustBookr comes from the fact that it's always been and always will be a textbook exchange and trade platfrom that allows students to trade their second hand textbooks on campus. This means that the whole site is made so that you can do just that, faster and easier.
                </p>
                <div class="d-block">
                    <router-link class="btn btn-primary mt-3" to="/discover">Find books sold on campus</router-link>
                    <router-link class="btn btn-secondary mt-3" to="/faq">Still have questions...</router-link>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <h2 class="display-4">🎓 <span class="light">{{ $t('buzzing') }}</span> {{ $t('universities').toLowerCase() }}</h2>
                <p class="lead">
                    {{ $t('uni_communities_really_active_on_justbookr') }}
                </p>
            </div>
        </div>
        <div class="row w-95 mx-auto" style="max-width: 1080px;">
            <router-link :to="'/university/'+university['uni-id']" v-for="(university, index) in universities" :key="university['uni-id']" class="col-md-3 col-sm-6 text-center mb-3 align-self-center" style="max-width: 50%;">
                <img class="rounded img-thumbnail" v-lazy="university['uni-logo']" onerror="this.src='/images/image_error.svg'" :alt="university['uni-name']" style="height:150px;background:#fff;">
                <small class="text-muted d-block">{{university['uni-name']}}</small>
            </router-link>
        </div>
        <div class="row w-95 mx-auto" style="max-width: 1080px;" v-if="country && country_university_count">
           <div class="col-md-12 text-center align-self-center">
                <router-link class="mb-4 mx-auto mt-auto mb-auto btn btn-secondary" :to="'/country/'+country+'/universities'">
                    +{{country_university_count}} universities in {{country_name}}
                </router-link>
            </div>
        </div>
        <div class="row w-95 mx-auto mt-5" style="min-height: 275px;">
            <div class="col-md-6 text-center align-self-center">
                <img class="responsive" src="/images/icons/custom/business/post.svg" alt="Book to sell at university" style="max-height: 300px;">
            </div>
            <div class="col-md-6 text-center align-self-center">
                <h2 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    Post books for sale
                </h2>
                <p>Where to sell student textbooks? Right here! Post your old textbooks for sale on your university campus so that other students can buy them. It's simple, and only face to face do money and textbook exchange!
                    <div class="d-block">
                        <router-link class="btn btn-primary mt-3" to="/sell">Post a textbook for sale</router-link>
                        <router-link class="btn btn-secondary mt-3" to="/faq">What? FAQ, please</router-link>
                    </div>
                </p>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import uniqBy from 'lodash/uniqBy'

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
        facebook_app_id: () => window.config.facebook_app_id,
        sortedBooks() {
            return uniqBy(this.suggested, 'isbn').slice(0, 8)
        }
    },

    data: () => ({
        title: window.config.appName,
        loading: true,
        suggested: [],
        universities: [],
        country: null,
        country_name: null,
        country_university_count: null,
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
                    if (response.data.data.length < 8) {
                        data.getRecent(13)
                    }
                } else {
                    data.getRecent(13)
                }
            })
        },
        getRecent(count) {
            this.loading = true
            var data = this
            axios('/api/v1/suggestions/recent?per_page=' + count).then(function(response) {
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
            axios("https://ipinfo.io").then(function(response) {
                data.country = response.data.country
                axios('/api/v1/universities?country=' + data.country).then(function(response) {
                    data.country_university_count = response.data.total
                    data.country_name = response.data.data[0].country.name
                })
            }, "jsonp")
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