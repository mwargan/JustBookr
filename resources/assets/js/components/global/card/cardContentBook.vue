<template>
  <div>
  <router-link v-if="isbn" :to="{ name: 'textbook.posts', params: {isbn: isbn } }" class="row mt-3">
    <div class="col-md-3 col-6 offset-md-1" v-if="image">
        <img class="image_fade" itemprop="image" v-lazy="image" onerror="this.src='/images/image_error.svg'" :alt="title">
    </div>
    <div class="col-6 align-self-center offset-md-2">
      <h6 style="color:black;" class="align-self-center">{{ title }}</h6>
      <p class="text-muted mb-0" v-if="text"><small>{{ text }}</small></p>
    </div>
  </router-link>
  <router-link v-else-if="link" :to="link" class="row mt-3">
    <div class="col-md-3 col-6 offset-md-1" v-if="image">
        <img class="image_fade" itemprop="image" v-lazy="image" onerror="this.src='/images/image_error.svg'" :alt="title">
    </div>
    <div class="col-6 align-self-center offset-md-2">
      <h6 style="color:black;" class="align-self-center">{{ title }}</h6>
      <p class="text-muted mb-0" v-if="text"><small>{{ text }}</small></p>
    </div>
  </router-link>
  <div v-else class="row mt-3">
    <div class="col-md-3 col-6 offset-md-1" v-if="image">
        <img class="image_fade" itemprop="image" v-lazy="image" onerror="this.src='/images/image_error.svg'" :alt="title">
    </div>
    <div class="col-6 align-self-center offset-md-2">
      <h6 style="color:black;" class="align-self-center">{{ title }}</h6>
      <p class="text-muted mb-0" v-if="text"><small>{{ text }}</small></p>
    </div>
  </div>
  </div>
</template>
<script>
export default {
  name: 'card-content-book',
  props: ['image', 'title', 'text', 'isbn', 'link']
}
</script>
<style scoped>
.image_fade {
  height:200px;
  object-fit:cover;
}
</style>