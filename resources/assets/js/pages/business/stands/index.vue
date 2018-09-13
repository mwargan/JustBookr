<template>
    <div>
        <page-header :title="business.name" subtext="Business" subtitle="On campus stands" :image="business.logo"></page-header>
<!-- <ul class="tg-list">
    <li class="tg-list-item">
            <h4>compare</h4>
        <input type="number" pattern="[0-9]*" name="isbn" class="form-control" >
    </li>
  <li class="tg-list-item">
    <h4>Light</h4>
    <input class="tgl tgl-light" id="cb1" type="checkbox"/>
    <label class="tgl-btn" for="cb1"></label>
  </li>
  <li class="tg-list-item">
    <h4>iOS</h4>
    <input class="tgl tgl-ios" id="cb2" type="checkbox"/>
    <label class="tgl-btn" for="cb2"></label>
  </li>
  <li class="tg-list-item">
    <h4>Skewed</h4>
    <input class="tgl tgl-skewed" id="cb3" type="checkbox"/>
    <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="cb3"></label>
  </li>
  <li class="tg-list-item">
    <h4>Flat</h4>
    <input class="tgl tgl-flat" id="cb4" type="checkbox"/>
    <label class="tgl-btn" for="cb4"></label>
  </li>
  <li class="tg-list-item">
    <h4>Flip</h4>
    <input class="tgl tgl-flip" id="cb5" type="checkbox"/>
    <label class="tgl-btn" data-tg-off="Nope" data-tg-on="Yeah!" for="cb5"></label>
  </li>
</ul> -->
            <card v-for="(stand, index) in stands" :key="'stand_'+stand.id">
                <card-header :title="stand.university['uni-name']" :image="stand.university['uni-logo']" :subtitle="stand.location+' ∙ '+stand.posts_count+' books '" :link="'/stand/'+stand.id" imageShape="square">
                </card-header>
                <template v-if="stand.is_active">
                    <card-footer :loading="stand.loading">
                        <router-link class="link" :to="'/stand/'+stand.id+'/add-books'">{{ $t('add_books') }}
                </router-link>
                    <a @click="deactivate(stand.id, index)" class="link" >{{ $t('deactivate') }}
                </a></card-footer>
                </template>
                <template v-else>
                    <card-footer :loading="stand.loading"><a @click="activate(stand.id, index)" class="link" >{{ $t('activate') }} for €19.57/month
                </a></card-footer>
                </template>
            </card>
            <card>
                <card-header :title="$t('create_a_new_stand')" icon="plus" link="/stand/create">
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
            axios.get('/api/v1/business-stands?paginate=false&business='+to.params.id).then(response => {
                $.each(response.data, function(res, val) {
                    val.loading = false
                })

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
        async activate(id, index) {
            this.stands[index].loading = true
            // how to update with reloading all the phone list?
            await axios.post('/api/v1/business-stands/' + id + '/activate').then(response => {
                this.stands[index].is_active = 1
                this.stands[index].loading = false
            })
        },
        async deactivate(id, index) {
            this.stands[index].loading = true
            // how to update with reloading all the phone list?
            await axios.post('/api/v1/business-stands/' + id + '/deactivate').then(response => {
                this.stands[index].is_active = 0
                this.stands[index].loading = false
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