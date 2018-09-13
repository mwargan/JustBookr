<template>
  <div :title="$t('home')">
    {{ $t('you_are_logged_in') }}
  </div>
</template>

<script>
export default {
  metaInfo () {
    return { title: this.$t('home') }
  }
}
</script>
