<template>
    <div>
        <transition name="fade" mode="out-in">
            <card>
                <card-header :title="$t('more_info')" />
                <card-content class="mt-2 mb-1">
                    <dl>
                        <dt>{{ $t('name') }}</dt>
                        <dd>{{ country.name }}</dd>
                    </dl>
                    <dl>
                        <dt>{{ $t('currency') }}</dt>
                        <dd>{{ country.currency_iso }}</dd>
                    </dl>
                    <dl>
                        <dt>{{ $t('currency_symbol') }}</dt>
                        <dd>{{ country.currency }}</dd>
                    </dl>
                </card-content>
            </card>
        </transition>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    scrollToTop: false,
    props: ['country', 'user'],
    metaInfo() {
        return {
            title: this.country.name + ' ' + this.$t('universities'),
            meta: [
                { name: 'description', content: "Find universities in "+this.country.name+" where you can trade textbooks on campus with fellow students on JustBookr!", vmid: 'description' },
            ]
        }
    },

    data: () => ({
        months: [],
        loaded: false,
        popular: false
    }),
    computed: {
        // ...mapGetters({
        //     user: 'auth/user'
        // })

    }
}
</script>