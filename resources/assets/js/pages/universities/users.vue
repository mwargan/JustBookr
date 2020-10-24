<template>
    <div>
        <card v-if="left <= 0">
            <card-header :title="$t('join_your_university_community')+'!'" link="/sign-up" subtitle="Sign up now!">
            </card-header>
        </card>
        <transition-group name="fade" mode="out-in">
            <card v-if="user" v-for="(user, index) in users" :key="user['user-id']">
                <card-header :link="'/user/'+user['user-id']" :title="fullNames[index]" :subtitle="$t('joined')+' '+$moment(user['user-registered'], 'X').fromNow()" :image="user.profilepic">
                </card-header>
            </card>
        </transition-group>
        <card-placeholder v-if="loading"></card-placeholder>
        <card v-if="left > 0">
            <card-header :title="'+ '+left+' '+$t('others').toLowerCase()"></card-header>
        </card>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    scrollToTop: true,
    props: ['university'],
    metaInfo() {
        return { title: this.university['uni-name']+' '+this.$t('students') }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
        orderPosts: function() {
            function compare(a, b) {
                return b.points - a.points
            }
            return this.users.sort(compare);
        },
        fullNames: function() {
            if (this.users) {
                return this.users.map(function(item) {
                    return item.name;
                })
            }
        },
        subtitle() {
            return this.users.map((b) => {
                //var price = `${b.university.country.currency}${b.price}`
                var availability = this.$t('sold')
                if (b.status) {
                    availability = this.$t('selling')
                }
                return `${availability} ${this.$t('this_book').toLowerCase()} ${this.$t('for').toLowerCase()} $12`
            })
        }
    },

    data: () => ({
        users: [],
        page: 1,
        left: 0,
        loading: false
    }),

    created() {
        this.getusers()
    },

    methods: {
        getusers() {
            this.loading = true
            var data = this

            axios('/api/v1/users?university=' + this.$route.params.id+'&order_by=user-registered').then(function(response) {
                data.page++
                    data.loading = false
                data.left = response.data.total - (response.data.per_page * response.data.current_page)
                $.each(response.data.data, function(res, val) {
                    data.users.push(val)
                })
            })
        }
    }

}
</script>