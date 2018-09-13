<template>
  <div class="card-header">
      <card-menu v-if="authenticated && menu"/>
      <span v-if="sponsored" class='small float-right text-muted'>{{sponsored}}</span>
      <router-link :to="{ path: link }" v-if="link">
          <div class="facebook-avatar" v-if="image">
              <img width="45" height="45" :alt="title" v-lazy="image" :class="shape" onerror="this.src='/images/JBicon.svg'">
          </div>
           <div class="facebook-avatar mr-1" v-else-if="icon">
              <fa :icon="icon" fixed-width/>
          </div>
          <div class="facebook-name" :class="margin" v-if="title">{{ title }}</div>
      </router-link>
      <template v-else>
          <div class="facebook-avatar" v-if="image">
              <img width="45" height="45" :alt="title" v-lazy="image" :class="shape" onerror="this.src='/images/JBicon.svg'">
          </div>
           <div class="facebook-avatar mr-1" v-else-if="icon">
              <fa :icon="icon" fixed-width/>
          </div>
          <div class="facebook-name" :class="margin" v-if="title">{{ title }}</div>
      </template>
      <div class="facebook-date" v-if="subtitle" :class="margin" v-html="subtitle"></div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'card-header',
  props: ['title', 'subtitle', 'image', 'imageShape', 'link', 'menu', 'sponsored', 'icon'],
  computed: {
    shape () {
      if (this.imageShape == "square") {
        return "scale-down"
      } else {
        return "rounded-circle cover"
      }
    },
    margin () {
      if (this.image) {
        return null
      } else {
        return "ml-0"
      }
    },
    ...mapGetters({
      authenticated: 'auth/check'
    })
  }
}
</script>