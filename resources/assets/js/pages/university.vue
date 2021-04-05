<template>
    <div :title="$t('university')">
        <img src="/images/uni.png" width="100%" style="height:200px;object-fit: scale-down;">
            <!-- University -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">{{ $t('your_university') }}</label>
                <div class="col-md-7">
                    <vue-fuse placeholder="Search for your university" :keys="keys" :list="universities" event-name="unisChanged" inputChangeEventName="uniSearchInputChanged" class="form-control" autofocus data-hj-whitelist></vue-fuse>
                    <small class="form-text text-muted">Select your university or college so JustBookr can show you posts and textbooks at your campus.</small>
                </div>
            </div>
        <card-placeholder v-if="loading"></card-placeholder>
        <card v-if="!loading" v-for="(university, index) in limitedResults" :key="'uni_'+university['uni-id']">
            <card-header @click.native="setUniversity(university['uni-id'])" :title="university['uni-name']" :subtitle="university.country.name" :image="university['uni-logo']" image-shape="square">
            </card-header>
        </card>
        <div style="text-align: center;">
            <small class="text-muted" v-if="country"><fa icon="compass" fixed-width/> {{ country }}</small>
            <small class="text-muted" v-else><fa icon="compass" fixed-width/> {{ $t('please_wait_while_we_fetch_universities_in_your_country') }}</small>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import API from '~/api/general'
import Form from 'vform'
import { mapGetters } from 'vuex'
import uniqBy from 'lodash/uniqBy'

export default {
        //layout: 'noEscape',
    metaInfo() {
        return { title: this.$t('university') }
    },
    data: () => ({
        universities: [],
        keys: ["uni-name", "en-name", "abr", "url", "country.name"],
        country: null,
        componentResults: [],
        loading: false,
        form: new Form({
            'university': null
        })
    }),
    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
        sortedUniversities () {
            return uniqBy(this.componentResults, 'uni-id')
          },
          limitedResults () {
            return this.sortedUniversities.slice(0,11)
          }
    },
    created() {
        this.getUniversities()
        this.$on('unisChanged', results => {
            this.componentResults = results
        })
    },
    methods: {
        async setUniversity(uni) {
            // Register the user.
            this.loading = true
            this.form.university = uni
            const { data } = await this.form.post('/api/v1/me/set-university')
            await this.$store.dispatch('auth/updateUser', { user: data })
            await this.$store.dispatch('auth/fetchUser')
            this.$router.push(this.$route.query.redirect || '/discover')

        },
        async getUniversities() {
            await API.index('universities').then((response) => {
                    API.parseResponseData(this, response.data.data, 'universities', false)
                })
            await axios("https://ipinfo.io").then((response) => {
                this.country = response.data.country

                API.index('universities?country=' + this.country + '&paginate=false').then((response) => {
                    API.parseResponseData(this, response.data.data, 'universities', false)
                })
            }, "jsonp");
        }
    }
}
</script>