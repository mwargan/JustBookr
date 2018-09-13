<template>
    <div :title="$t('your_info')">
        <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
                <a class="btn btn-warning" href="mailto:support@justbookr.com?subject=Requesting%20all%20my%20data&amp;body=Hello!%20I%20request%20all%20the%20data%20you%20have%20on%20me.">Request all your data</a>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
                <a class="btn btn-danger" href="mailto:support@justbookr.com?subject=Delete%20my%20data%20and%20account&amp;body=Hello!%20I%20request%20that%20you%20delete%20all%20the%20data%20you%20have%20on%20me.">Delete all your data and close your account</a>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
                <small class="text-muted mb-0">When reaching out to the JustBookr Help team we may ask for your User ID. It's {{user['user-id']}}.</small></div>
        </div>
    </div>
</template>
<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
    scrollToTop: true,

    metaInfo() {
        return { title: this.$t('settings') }
    },

    data: () => ({
        form: new Form({

        })
    }),

    computed: mapGetters({
        user: 'auth/user'
    }),

    created() {},

    methods: {}
}
</script>