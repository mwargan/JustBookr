<template>
    <div>
                <div class="row mt-4">
            <div class="col-12 text-center">
                <h1 class="display-5">Students</h1>
                <p class="lead">
                  By last log in
                </p>
            </div>
        </div>
            <card>
                <card-content class="mt-2 mb-1">
                    <dl v-for="(user, index) in users">
                        <dt><router-link :to="'/user/'+user['user-id']">{{ user.name }}</router-link></dt>
                        <dd>At <router-link :to="'/university/'+user['uni-id']">{{user['uni-id']}}</router-link>
                            <small class="d-block">{{ getHumanDate(user.last_login) }}</small>
                        </dd>
                    </dl>
                </card-content>
            </card>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    scrollToTop: false,
    metaInfo() {
        return {
            title: "User data",
        }
    },

    data: () => ({
        users: []
    }),
    computed: {
        ...mapGetters({
           // thisBook: 'book/getBookByIsbn'
        }),

    },
    created() { 
this.getUsers()
    },
    methods: {
        async getUsers() {
            var data = this
            await axios('/api/v1/users?order_by=last_login&per_page=15').then(function(response) {
                data.$set(data, 'users', response.data.data)
                $.each(response.data.data, function(res, val) {
                    data.$store.dispatch('user/addUser', val)
                })
            })
        },
        getHumanDate(date) {
            date = Number(date)
            console.log(date)
            return this.$moment(date, 'X').fromNow()
        }
    }
}
</script>