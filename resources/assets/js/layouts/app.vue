<template>
    <div class="app-layout">
        <navbar></navbar>
        <div class="container-fluid mt-4 full-height">
            <child/>
        </div>
        <footer class="footer border-top mt-3" id="page-footer">
            <div class="container">
                <span class="text-muted">JustBookr 2018</span> | <router-link to="/faq">{{ $t('frequently_asked_questions') }}</router-link> | <router-link to="/terms-and-conditions">{{ $t('terms_and_conditions') }}</router-link> | <router-link to="/business">{{ $t('justbookr_for_business') }}</router-link> | <a target="_BLANK" href="https://instagram.com/JustBookr" rel="noopener">Instagram</a> | <a target="_BLANK" href="https://facebook.com/JustBookr" rel="noopener">Facebook</a><!--  |
                <locale-dropdown style="display: inline-block;left:-16px;" /> -->
            </div>
        </footer>
        <nav class="navbar fixed-bottom navbar-light navbar-expand-lg bg-white b-nav">
            <ul class="navbar-nav w-100 d-flex justify-content-between">
                <!-- Authenticated -->
                <li v-if="user" class="nav-item">
                    <router-link :to="{ name: 'profile.inbox' }" class="nav-link text-dark py-1 m-3" style="position:relative;">
                        {{ $t("inbox") }} <span v-if="user.unread_orders > 0" class="alert-badge" style="margin-left: 0; margin-bottom: -1px;"></span>
                    </router-link>
                </li>
                <li v-if="user" class="nav-item">
                    <router-link :to="{ name: 'sell' }" class="nav-link py-1 m-3 text-success">
                        {{ $t("sell_textbooks") }}
                    </router-link>
                </li>
                <li v-if="user" class="nav-item dropdown">
                    <a class="nav-link text-dark py-1 m-3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          More
                        </a>
                    <div class="dropdown-menu">
                        <router-link :to="{ name: 'profile.community' }" class="dropdown-item p-3">
                            {{ $t('profile') }}
                        </router-link>
                        <router-link :to="{ name: 'profile.my-textbooks' }" class="dropdown-item p-3">
                            {{ $t("your_textbooks") }}
                        </router-link>
                        <router-link :to="{ name: 'settings.profile' }" class="dropdown-item p-3">
                            {{ $t('settings') }}
                        </router-link>
                        <template v-if="user.businesses && user.businesses.length > 0">
                            <div class="dropdown-divider"></div>
                            <router-link :to="{ name: 'business.home' }" class="dropdown-item p-3">
                                {{ $t('your_business') }}
                            </router-link>
                        </template>
                        <template v-if="user['user-id'] == 1">
                            <div class="dropdown-divider"></div>
                            <router-link to="/data" class="dropdown-item p-3">
                                {{ $t('data_center') }}
                            </router-link>
                        </template>
                        <div class="dropdown-divider"></div>
                        <a @click.prevent="logout" class="dropdown-item p-3" href="#">
                            {{ $t('logout') }}
                        </a>
                    </div>
                </li>
                <!-- Guest -->
                <template v-else>
                    <li class="nav-item">
                        <router-link :to="{ name: 'login' }" class="nav-link py-1 m-3" active-class="active">
                            {{ $t('login') }}
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'register' }" class="nav-link py-1 m-3 text-primary" active-class="active">
                            {{ $t('sign_up') }}
                        </router-link>
                    </li>
                </template>
            </ul>
        </nav>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import Navbar from '~/components/Navbar'
import LocaleDropdown from '~/components/LocaleDropdown'

export default {
    name: 'app-layout',

    components: {
        Navbar,
        LocaleDropdown
    },
    computed: {
        ...mapGetters({
            user: 'auth/user'
        })
    },
    methods: {

        async logout() {
            // Log out the user.
            await this.$store.dispatch('auth/logout')

            // Redirect to login.
            location.reload()
        }
    }
}
</script>
<style scoped>
.navbar-nav {
    flex-direction: row;
}

.navbar-expand-lg .navbar-nav .dropdown-menu {
    position: absolute;
    bottom: 100%;
    right: 0;
    top: auto;
    left: auto;
}

.b-nav {
    height: 4.1rem;
    border-top: 1px solid #dee9f2;
}

#page-footer {
    padding-bottom: 4.1rem;
}

.alert-badge {
    height: 10px;
    width: 10px;
    background-color: red;
    border-radius: 50%;
    display: inline-block;
    display: inline-block;
    border: 1px solid white;
    position: absolute;
    top: 5px;
    right: 0px;
}
.full-height {
       min-height: 100vh;
       /*padding: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);*/
     }
@media (min-width: 992px) {
    .b-nav {
        display: none;
    }
    #page-footer {
        padding-bottom: initial;
    }
}
</style>