<template>
  <div class="row">
    <div class="col-md-3">
      <div :title="$t('settings')" class="settings-card">
        <ul class="nav flex-column nav-pills">
          <li v-for="tab in tabs" class="nav-item">
            <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
              <!-- <fa :icon="tab.icon" fixed-width/> -->
              {{ tab.name }}
            </router-link>
          </li>
        </ul>
      </div>
    </div>

    <div class="col-md-9">
      <transition name="fade" mode="out-in">
        <router-view></router-view>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  loading: true,

  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'graduation-cap',
          name: this.$t('university'),
          route: 'profile.university'
        },
        // {
        //   icon: 'money-bill',
        //   name: this.$t('payment'),
        //   route: 'settings.payment'
        // },
        {
          icon: 'lock',
          name: this.$t('password'),
          route: 'settings.password'
        },
        {
          icon: 'lock',
          name: this.$t('privacy'),
          route: 'settings.privacy'
        },
        {
          icon: 'lock',
          name: this.$t('authorized_applications'),
          route: 'settings.applications'
        },
        {
          icon: 'lock',
          name: this.$t('developer_settings'),
          route: 'settings.developer'
        }
      ]
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
