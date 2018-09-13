<template>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button"
      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      {{ locales[locale] }}
    </a>
    <div class="dropdown-menu">
      <a v-if="locales" v-for="(value, key) in locales" class="dropdown-item" href="#"
        @click.prevent="setLocale(key)">
        {{ value }}
      </a>
      <div v-if="locales" v-for="(value, key) in locales" class="dropdown-item">
        {{ $t('more_languages_coming_soon') }}!
      </div>
    </div>
  </li>
</template>

<script>
import { mapGetters } from 'vuex'
import { setLocale } from '~/plugins/i18n'

export default {

  computed: mapGetters({
    locale: 'lang/locale',
    locales: 'lang/locales'
  }),

  methods: {
    setLocale
  }
}
</script>
