<template>
    <div class="app-layout">
        <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
            <div class="container" style="max-width: 100%;">
                <div class="navbar-brand">
                    <img itemprop="image" src="/images/logoDark.svg" height="45" alt="JustBookr Logo">
                </div>
            </div>
        </nav>
        <div class="container-fluid mt-4 full-height">
            <child/>
        </div>
        <footer class="footer border-top mt-3" id="page-footer">
            <div class="container">
                <span class="text-muted">JustBookr</span> |
                <router-link to="/terms-and-conditions">{{ $t('terms_and_conditions') }}</router-link> |
                <router-link to="/business">{{ $t('justbookr_for_business') }}</router-link> |
                <locale-dropdown style="display: inline-block;left:-16px;" />
            </div>
        </footer>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import Navbar from '~/components/Navbar'
import LocaleDropdown from '~/components/LocaleDropdown'

export default {
    name: 'noEscape',

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
.navbar {
    font-weight: 500;
    border-bottom: 1px solid #dee9f2;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
}
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