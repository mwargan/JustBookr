<template>
    <div>
        <template v-if="loading">
            <v-button key="loading" :loading="true" disabled class="mb-3 w-100" style="min-height:32px;background: none;border: none;"></v-button>
        </template>
        <template v-else-if="raw_data && months && raw_data.length > 0">
            <div class="m-auto w-100">
                <trend :data="months" :gradient="['#3e73b9']" auto-draw smooth>
                </trend>
                <small class="form-text text-muted pb-0 mt-0">{{ $t('last_year') }}<span class="float-right">{{ $t('now') }}</span></small>
            </div>
            <ul class="list-group list-group-flush pt-2" v-if="popular">
                <li class="list-group-item text-muted pb-0 pl-0 pr-0">Very popular this month</li>
            </ul>
        </template>
        <p class="text-muted mb-0" v-else>
            Fear not! Soon there will be enough data to show you a magnificent chart.</p>
    </div>
</template>
<script>
export default {
    props: ['raw_data'],
    data: () => ({
        months: [],
        popular: false,
        loading: true
    }),
    created() {
        if (this.raw_data && this.raw_data.length > 0) {
            this.setTrend()
        } else {
            setTimeout(this.stopLoading, 3000);
        }
    },
    watch: {
        'raw_data': function() {
            if (this.raw_data && this.raw_data.length > 0) {
                this.loading = true
                this.setTrend()
            } else {
                this.loading = false
            }
        }
    },
    methods: {
        setTrend() {
            var step
            var views = []
            if (!this.raw_data || this.raw_data.length < 1) {
                this.loading = false
                return false
            }
            for (step = 0; step < 12; step++) {
                var count = this.raw_data.find(view => view.month === (step + 1))
                if (count) {
                    views.push(count.score + 1)
                } else {
                    views.push(1)
                }
            }
            var indexOfMaxValue = views.reduce((iMax, x, i, arr) => x > arr[iMax] ? i : iMax, 0)
            var current = new Date().getMonth()
            if (current == indexOfMaxValue) {
                this.popular = true
            }
            this.months = views.concat(views.splice(0, (current + 1)))
            this.loading = false
        },
        stopLoading() {
             this.loading = false
        }
    }
}
</script>
<style scoped>
</style>