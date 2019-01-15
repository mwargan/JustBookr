<template>
    <div>
        <page-header :title="'Stand '+stand.location.toLowerCase()" :subtext="subtext" :subtitle="subtitle" :image="business.logo"></page-header>
        <!-- <div class="facebook-card card row">
          <div class="card-header">
            About
          </div>
          <div class="card-body">
            <h5 class="card-title">{{ business.name }}</h5>
            <p class="card-text">{{ business.description }}</p>
          </div>
          <card-footer v-if="business.website">
            <a class="link" target="_BLANK" :href="business.website">{{ $t('visit_website') }}
                </a>
          </card-footer>
        </div> -->
        <div class="facebook-card card row" v-if="stand.dates">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div>Opens on Tuesday, May 5th at 13:00</div>
                    <router-link :to="'book'" class="text-muted">Closes at 17:00</router-link>
                </li>
            </ul>
        </div>
        <template v-if="stand.posts.length > 0">
            <card>
                <card-header icon="info" :title="$t('purchase_books_from_this_stand_by_visiting_them_on_campus')+'.'" :subtitle="stand.stand_text">
            </card-header>
            </card>
            <card v-for="(post, index) in stand.posts" :key="post.id">
                <card-header :title="stand.business.name" :subtitle="post.price" :image="stand.business.logo" :link="'/business/'+stand.business.id">
                </card-header>
                <card-content :text="post.description">
                    <card-content-book :title="post.textbook['book-title']" :subtitle="post.textbook['author']" :image="post.textbook['image-url']" :text="post.textbook['edition']" :isbn="post.textbook.isbn"></card-content-book>
                </card-content>
            </card>
        </template>
        <card v-else>
            <card-header :title="$t('this_stand_isnt_selling_any_books_right_now')+'.'">
            </card-header>
        </card>
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
        //this.getSuggested()
        //this.getUniversities()
    },
    beforeRouteEnter(to, from, next) {
        axios.get('/api/v1/business-stands/' + to.params.stand_id).then(response => {
            if (!response.data.is_active) {
                next('/404')
            } else {
                next(vm => {
                    vm.business = response.data.business
                    vm.stand = response.data
                })
            }
            }, error => {
                next('/404')
            }
        )
    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/check'
        }),
        subtitle() {
            return this.$t("at") + " <a href='/university/" + this.stand.university['uni-id'] + "'>" + this.stand.university['uni-name'] + "</a>"
        },
        subtext() {
            return this.$t("by") + " <a href='/business/" + this.stand.business.id + "'>" + this.stand.business.name + "</a> ∙ " + this.$t("sponsored")
        },
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
        business: {},
        stand: {}
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