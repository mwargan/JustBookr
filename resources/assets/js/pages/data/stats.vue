<template>
    <div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <h1 class="display-5">Popularity</h1>
                <p class="lead">
                    Past year performance of the top universities
                </p>
            </div>
        </div>
        <div class="facebook-card card row mt-3" v-if="uni.months.length > 0" v-for="uni in universities" :key="uni['uni-id']">
            <div class="card-header">
                {{ $t('popularity') }} <span>{{$t('at').toLowerCase()}} {{uni['uni-name']}}</span>
            </div>
            <div class="m-auto w-100 ">
                <trend :data="uni['months']" :gradient="['#3e73b9']">
                </trend>
                <small class="form-text text-muted pl-3 pr-3 pb-3 mt-0">{{ $t('last_year') }}<span class="float-right">{{ $t('now') }}</span></small>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    scrollToTop: false,
    metaInfo() {
        return {
            title: "Stats data",
        }
    },

    data: () => ({
        universities: []
    }),
    computed: {
        ...mapGetters({
            // thisBook: 'book/getBookByIsbn'
        }),

    },
    created() {
        this.getTrends()
    },
    methods: {
        getTrends() {
            var data = this
            axios('/api/v1/universities?per_page=8').then(resp => {
                $.each(resp.data.data, function(res, val) {
                    val.months = []
                    axios('/api/v1/universities/' + val['uni-id'] + "/views").then(response => {
                        //console.log(response.data)
                        var step
                        var views = []
                        for (step = 0; step < 12; step++) {
                            var count = response.data.find(view => view.month === (step + 1))
                            if (count) {
                                views.push(count.score + 1)
                            } else {
                                views.push(1)
                            }
                        }
                        //val.months = views
                        var current = new Date().getMonth()
                        val.months = views.concat(views.splice(0, (current + 1)))

                    })
                    data.universities.push(val)
                    console.log(val)
                })
            })
        }
    }
}
</script>