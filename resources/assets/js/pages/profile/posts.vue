<template>
    <div>
        <div class="row page-header mb-2">
            <div class="col-sm-6">
                <label class="profile-photo"><img class="profile-photo" onerror="this.src='/images/image_error.svg'" :src="this.user.profilepic" :alt="fullName">
                    <input type="file" name="image" @change="selectFile" class="hidden-file" required id="image">
                </label>
            </div>
            <div class="col-sm-6 m-auto">
                <h1 class="mt-1">{{ fullName }}</h1>
                <h5 v-if="subtitle" v-html="subtitle"></h5>
                <transition name="fade">
                    <span class="text-muted" v-if="subtext" v-html="subtext"></span>
                </transition>
            </div>
        </div>
        <div class="row">
            <ul class="nav nav-pills" style="margin-bottom:1rem;">
                <li v-for="tab in tabs" class="nav-item">
                    <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
                        <fa :icon="tab.icon" fixed-width/> {{ tab.name }} <span v-if="tab.route === 'profile.inbox' && user.unread_orders > 0" class="alert-badge"></span>
                    </router-link>
                </li>
            </ul>
        </div>
        <!-- <keep-alive> -->
        <router-view :user="user"></router-view>
        <!-- </keep-alive> -->
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import Form from 'vform'
import objectToFormData from 'object-to-formdata'

export default {

    metaInfo() {
        return { title: this.$t('posts') }
    },

    data: () => ({
        page: 1,
        loading: false,
        form: new Form({
            image: null
        })
    }),
    computed: {
        tabs() {
            return [{
                    icon: "users",
                    name: this.$t('discover'),
                    route: 'profile.community'
                },
                {
                    icon: "book",
                    name: this.$t('textbooks'),
                    route: 'profile.my-textbooks'
                },
                {
                    icon: "inbox",
                    name: this.$t('inbox'),
                    route: 'profile.inbox'
                }
            ]
        },
        fullName() {
            return this.user.name
        },
        subtitle() {
            if (this.user.university)
                return this.$t("at") + " <a href='/university/" + this.user.university['uni-id'] + "'>" + this.user.university['uni-name'] + "</a>"
        },
        subtext() {
            if (this.user.positive_ratings) {
                return this.user.positive_ratings + " " + this.$t('positive_ratings').toLowerCase()
            }
        },
        ...mapGetters({
            user: 'auth/user'
        })
    },
    methods: {
        selectFile(e) {
            const file = e.target.files[0]
            this.form.image = file
            this.post()
        },
        async post() {

            var v = this
            this.form.submit('post', '/api/v1/me/profile-picture', {
                    // Transform form data to FormData
                    transformRequest: [function(data, headers) {
                        return objectToFormData(v.form)
                    }],
                    onUploadProgress: e => {
                        // Do whatever you want with the progress event
                        //console.log(e)
                    }
                })
                .then(({ data }) => {
                    data.email = this.user.email

                    this.$store.dispatch('auth/updateUser', { user: data })

                    v.form.reset()
                })
        }
    }
}
</script>
<style scoped>
.nav-item {
    margin: 0 auto;
}

.nav {
    width: 100%;
}

.nav-link {
    border-radius: 1rem;
    border: none;
}

.alert-badge {
    height: 10px;
    width: 10px;
    background-color: red;
    border-radius: 50%;
    display: inline-block;
    display: inline-block;
}

.profile-photo {
    max-height: 200px;
    max-width: 400px;
    object-fit: scale-down;
    min-height: 125px;
    margin: 0 auto;
    display: block;
    border-radius: 0.3rem;
}

label.profile-photo {
    position: relative;
    cursor: pointer;
}
/*label.profile-photo::after {
    position: absolute;
    height:100%;
    width:100%;
    background:#333;
}*/

.hidden-file {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
}

@media (max-width: 768px) {
    .page-header {
        text-align: center;
    }
}
</style>