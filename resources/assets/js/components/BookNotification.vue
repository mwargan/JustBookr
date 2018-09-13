<template>
    <div>
        <!--       <transition-group name="list-complete">
 -->
        <template v-if="initial_loading">
            <v-button key="loading" :loading="true" disabled style="min-height:32px;background: none;width: 100%;border: none;"></v-button>
        </template>
        <template v-else-if="user">
            <div class="float-left mr-1" key="toggle">
                <input class="tgl tgl-light" id="cb1" type="checkbox" v-model="notifications" :disabled="loading" />
                <label class="tgl-btn" for="cb1"></label>
            </div>
            <label for="cb1" class="form-text text-muted mb-0" key="label">
                <transition name="fade" mode="out-in">
                    <p style="line-height: 2rem;" class="mb-0" :key="label_text">{{label_text}}</p>
                </transition>
            </label>
        </template>
        <p class="text-muted mb-0" v-else key="login">
            <router-link :to="'/login?redirect='+$route.path">Log in</router-link> to manage if you recieve notifications every time a new post is added for this book.</p>
        <!--       </transition-group>
 -->
    </div>
</template>
<script>
import axios from 'axios'

export default {
    props: ['book', 'user'],
    data: () => ({
        notifications: false,
        notification: {},
        loading: false,
        initial_loading: true,
        label_text: "Hold on! We're still fetching some stuff..."
    }),
    watch: {
        'notifications': function(id) {
            this.loading = true
            if (this.notifications == true && !this.notification.id) {
                this.setNotification(this.book.isbn)
            } else if (this.notifications == false && this.notification.id) {
                this.deleteNotification(this.notification.id)
            }
        }
    },
    async created() {
        if (this.user) {
            await axios(`/api/v1/book-notifications?user=${this.user['user-id']}&university=${this.user['uni-id']}&isbn=${this.book.isbn}`).then(response => {
                this.notification = response.data.data[0]
                if (this.notification) {
                    this.notifications = true
                } else {
                    this.notification = {}
                    this.notifications = false
                }
            }).catch(e => {
                this.notification = {}
                this.notifications = false
            })
        }
        this.loading = false
        this.initial_loading = false
        this.setText(true)
    },
    methods: {
        async setNotification() {
            await axios.post('/api/v1/book-notifications', this.book)
                .then(response => {
                    this.notification = response.data
                    this.notifications = true
                })
                .catch(error => {
                    this.notification = {}
                    this.notifications = false
                })
            this.loading = false
            this.setText()
        },
        async deleteNotification(id) {
            await axios.delete('/api/v1/book-notifications/' + id)
                .then(response => {
                    this.notification = {}
                    this.notifications = false
                }).catch(e => {
                    this.notifications = true
                })
            this.loading = false
            this.setText()
        },
        setText(direct = false) {
            if (this.notification && this.notifications == true && direct == false) {
                var texts = [this.$t('nice'), this.$t('awesome'), this.$t('high_five'), this.$t('cool'), this.$t('great_job'), this.$t('nicely_done')]
                this.label_text = texts[Math.floor(Math.random() * texts.length)]+"!"
                this.loading = true
                setTimeout(() => {
                    this.$set(this, 'label_text', "You are being notified every time there is a new post for this book.")
                    this.loading = false
                }, 1300)
            } else if (this.notification && this.notifications == true) {
                this.label_text = "You are being notified every time there is a new post for this book."
            } else {
                this.label_text = "Tap to get notified every time there is a new post available for this book."
            }

        }
    }
}
</script>
<style scoped>
.list-complete-item {
    transition: all 1s;
}

.list-complete-enter,
.list-complete-leave-to
/* .list-complete-leave-active below version 2.1.8 */

{
    /*transition: all 1s;*/
    opacity: 0;
}

.list-complete-leave-active {
    position: absolute;
}
</style>