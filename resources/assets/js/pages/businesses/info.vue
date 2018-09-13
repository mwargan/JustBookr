<template>
  <div class="mx-auto">
    <div class="facebook-card card row">
      <div class="card-body">
        <h5 class="card-title">{{ business.name }}</h5>
        <p class="card-text">{{ business.description }}</p>
      </div>
      <card-footer v-if="business.website">
        <a class="link" target="_BLANK" :href="business.website" rel="noopener">{{ $t('visit_website') }}
            </a>
      </card-footer>
    </div>
    <div class="facebook-card card row mt-3" v-if="business.stands && business.stands.length > 0">
      <div class="card-header">
        On campus
      </div>
      <ul class="list-group list-group-flush">
        <router-link :to="'/stand/'+stand.id" class="list-group-item" :key="stand.id" v-for="stand in business.stands">
            <!-- <img width="45" height="45" alt="Caroline Birch" class="cover facebook-avatar float-left mr-3 clearfix" :src="view.seller.avatar"> -->
            <div>{{ stand.university['uni-name'] }}</div>
            <div class="text-muted">{{ stand.location }} <span v-if="stand.nearest_open_date && stand.nearest_close_date">∙ {{ getHumanDate(stand.nearest_open_date, stand.nearest_close_date) }}</span><span v-else>∙ Opening times not available</span></div>
        </router-link>
      </ul>
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'default',
  props: ['business'],
  head() {
    return { title: this.$t('view') }
  },

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  data: () => ({
    title: process.env.appName
  }),
    methods: {
        getHumanDate: function(open, close) {
            open = this.$moment(Number(open), 'X')
            close = this.$moment(Number(close), 'X')
            if (this.$moment().isAfter(open)) {
                return "Open until "+close.format("h:mm a")
            }
            return "Opens "+open.calendar().toLowerCase()
        },
    }
}

</script>
<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 3rem;
}

.card-img-top {
  height: 200px;
  object-fit: cover;
}

.price {
  color: green;
}

.spacer {
  height: 5rem;
}

.reserve-button {
  max-width: 50rem;
}

.cover-image {
  object-fit: cover;
  margin-top: -1.5rem;
}
.card-header {
    background-color: #fff;
}
</style>
