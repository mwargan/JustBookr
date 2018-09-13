<template>
    <div>
            <card v-for="(stand, index) in stands" :key="'stand_'+stand.id">
                <card-header :title="stand.university['uni-name']" :image="stand.university['uni-logo']" :subtitle="stand.location+' ∙ '+stand.posts_count+' posts'" :link="'/stand/'+stand.id" imageShape="square">
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
        axios.get('/api/v1/businesses/'+to.params.id).then(response => {
            var business = response.data
            axios.get('/api/v1/business-stands/?paginate=false&active=true&business='+to.params.id).then(response => {

            next(vm => {
                           vm.business = business
                           vm.stands = response.data
                       })
            }, error => {
                // handle error here
            })
        }, error => {
            // handle error here
        })
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
        business: {},
        stands: []
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