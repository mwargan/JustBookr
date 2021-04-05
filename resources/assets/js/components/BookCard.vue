<template>
  <router-link
    :class="size+'-book-card'"
    :to="'/books/'+isbn"
  >
    <img
      v-fallback-image
      :src="image"
      :alt="title"
    >
    <div>
      <div>{{ title }}</div>
      <div>{{ subtitle }}</div>
    </div>
  </router-link>
</template>
<script>
export default {
    name: 'LargeBookCard',
    props: {
        size: {
            type: String,
            default: 'small',
            required: false
        },
        title: {
            type: String,
            required: true
        },
        subtitle: {
            type: String,
            default: null,
            required: false
        },
        image: {
            type: String,
            required: true
        },
        isbn: {
            type: String,
            required: true
        }
    },
}

</script>
