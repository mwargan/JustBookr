<template>
  <div class="card-content">
      <div class="card-content-inner">
          <p class="emotis mb-0" v-if="text">{{ text }}</p>
          <slot></slot>
      </div>
  </div>
</template>

<script>
export default {
  name: 'card-content',
  props: ['po', 'title', 'subtitle', 'text']
}
</script>