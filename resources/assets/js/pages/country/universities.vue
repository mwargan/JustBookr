<template>
    <div>
        <div class="title">{{total}} {{ $t('universities') }}</div>
        <card v-if="university" v-for="(university, index) in universities" :key="university['uni-id']">
            <card-header :title="university['uni-name']" :subtitle="university['en-name']" :image="university['uni-logo']" :link="'/university/'+university['uni-id']+'/info'" />
        </card>
        <transition name="fade" mode="out-in">
            <card-placeholder v-if="loading"></card-placeholder>
        </transition>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    scrollToTop: true,
    props: ['country', 'user'],
    metaInfo() {
        return {
            title: this.country.name + ' ' + this.$t('universities')
        }
    },

    computed: {
        ...mapGetters({
            //user: 'auth/user',
            //thiscountry: 'country/getcountryByiso'
        })
    },

    data: () => ({
        universities: [],
        page: 1,
        total: 100,
        loading: false
    }),
    watch: {
        '$route.params.iso': function(id) {
            this.getuniversities()
        }
    },
    created() {
        this.getuniversities()
    },
    beforeRouteLeave(to, from, next) {
        window.removeEventListener('scroll', this.handleScroll)
        next()
    },

    beforeRouteEnter(to, from, next) {
        next(vm => {
            window.addEventListener('scroll', vm.handleScroll)
        })
    },
    methods: {

        async getuniversities() {
            this.loading = true
            var data = this
            await axios('/api/v1/universities?country=' + this.$route.params.iso + '&page='+this.page).then(response => {
                this.page++
                this.loading = false
                this.total = response.data.total
                $.each(response.data.data, function(res, val) {
                    data.universities.push(val)
                })
                if (response.data.data.length <= 8) {
                    window.removeEventListener('scroll', data.handleScroll)
                    return false
                }
            })
        },
        handleScroll() {
            if (((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 1300) && this.loading === false) {
                this.getuniversities()
            }
        }
    }

}
</script>
<style scoped>
.title {
    max-width: 700px;
    margin: 0 auto;
    color: #b3b3b3;
    font-size: 2rem;
}
</style>