<template>
  <div class="dropdown dropleft">
      <fa icon="ellipsis-v" fixed-width class="text-muted dropdown-toggle float-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"/>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <template v-if="user['user-id'] === id">
          <a class="dropdown-item" href="#">Mark as sold</a>
          <a class="dropdown-item" href="#">Edit post</a>
          <a class="dropdown-item" href="#">Share on Facebook</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Delete post</a>
        </template>
        <template v-else>
          <a class="dropdown-item" href="#">Report post</a>
        </template>
      </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'card-menu',
  props: ['id'],
  computed: {
    ...mapGetters({
      user: 'auth/user'
    })
  }
}
</script>