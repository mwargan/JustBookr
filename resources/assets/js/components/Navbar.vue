<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container" style="max-width: 100%;">
            <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
                <img itemprop="image" src="/images/logoDark.svg" height="45" alt="JustBookr Logo" />
            </router-link>
            <form class="form-inline my-2 my-lg-0" action="#" v-on:submit.prevent="submit" method="get" style="max-width: 73%;">
                <input required name="query" v-model="searchQ" class="form-control search-input" type="search" :placeholder="$t('find_books')" aria-label="Search" list="suggestionsList">
                <datalist id="suggestionsList">
                    <option :value="book['book-title']" v-for="book in sortedBooks"></option>
                    <option :value="uni['uni-name']" v-for="uni in sortedUniversities"></option>
                </datalist>
            </form>
            <!--                 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" :aria-label="$t('toggle_navigation')">
                    <span class="navbar-toggler-icon"></span>
                </button> -->
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <!-- <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li> -->
                </ul>
                <ul class="navbar-nav">
                    <!-- Authenticated -->
                    <li v-if="user" class="nav-item">
                        <router-link :to="{ name: 'profile.my-textbooks' }" class="nav-link text-dark py-1 mr-1">
                            {{ $t("your_books") }}
                        </router-link>
                    </li>
                    <li v-if="user" class="nav-item">
                        <router-link :to="{ name: 'profile.inbox' }" class="nav-link text-dark py-1 mr-1" style="position:relative;">
                            {{ $t("inbox") }} <span v-if="user.unread_orders > 0" class="alert-badge" style="margin-left: 0; margin-bottom: -1px;"></span>
                        </router-link>
                    </li>
                    <li v-if="user" class="nav-item">
                        <router-link :to="{ name: 'sell' }" class="nav-link py-1 mr-3 text-success">
                            {{ $t("sell_a_book") }}
                        </router-link>
                    </li>
                    <li v-if="user" class="nav-item dropdown">
                        <a class="nav-link text-dark py-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <img :src="user.profilepic" onerror="this.src='/images/JBicon.svg'" class="rounded-circle profile-photo">
                        </a>
                        <div class="dropdown-menu">
                            <router-link :to="{ name: 'profile.community' }" class="dropdown-item p-3">
                                <fa icon="user" fixed-width/> {{ $t('profile') }}
                            </router-link>
                            <router-link :to="{ name: 'settings.profile' }" class="dropdown-item p-3">
                                <fa icon="cog" fixed-width/> {{ $t('settings') }}
                            </router-link>
                            <template v-if="user.businesses && user.businesses.length > 0">
                                <div class="dropdown-divider"></div>
                                <router-link :to="{ name: 'business.home' }" class="dropdown-item p-3">
                                    <fa icon="briefcase" fixed-width/> {{ $t('your_business') }}
                                </router-link>
                            </template>
                            <template v-if="user['user-id'] == 1">
                                <div class="dropdown-divider"></div>
                                <a href="https://data.justbookr.com" class="dropdown-item p-3">
                                   <fa icon="chart-bar" fixed-width/> {{ $t('data_center') }}
                                </a>
                            </template>
                            <div class="dropdown-divider"></div>
                            <a @click.prevent="logout" class="dropdown-item p-3" href="#">
                                <fa icon="sign-out-alt" fixed-width/> {{ $t('logout') }}
                            </a>
                        </div>
                    </li>
                    <!-- Guest -->
                    <template v-else>
                        <li class="nav-item">
                            <router-link :to="{ name: 'login' }" class="nav-link btn" active-class="active">
                                {{ $t('login') }}
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'register' }" class="nav-link btn" active-class="active">
                                {{ $t('sign_up') }}
                            </router-link>
                        </li>
                    </template>
                    <!-- <li v-if="user" class="nav-item dropdown d-flex align-items-center">
                        <a class="nav-link text-dark py-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <fa icon="bell" fixed-width size="lg"/>

                        </a>
                        <div class="dropdown-menu">
                            <card class="mb-1">
                                <card-header title="You've ordered Business Ethics - Ethical Decision Making  and Cases" subtitle="from Silvia" link="hello" image="test" image-shape="square" />
                            </card>
                            <card class="mb-1">
                                <card-header title="You've got a new order" subtitle="Micha\u0142 wants to buy Amical A2 - Livre de l'\u00e9l\u00e8ve from you" link="hello" image="test" image-shape="square" />
                            </card>
                            <card>
                                <card-header title="You've ordered Business Ethics - Ethical Decision Making  and Cases" subtitle="from Silvia" link="hello" image="test" image-shape="square" />
                            </card>
                        </div>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'
import uniqBy from 'lodash/uniqBy'

export default {
    data: () => ({
        appName: window.config.appName,
        action: "/find/",
        searchQ: null
    }),

    computed: {
        ...mapGetters({
            user: 'auth/user',
            allBooks: 'book/books',
            allUniversities: 'university/universities'
        }),
        sortedBooks() {
            return uniqBy(this.allBooks, 'book-title')
        },
        sortedUniversities() {
            return uniqBy(this.allUniversities, 'uni-name')
        }
    },

    components: {
        LocaleDropdown
    },
    mounted() {
        var self = this
    },
    methods: {
        submit() {
            this.$router.push({ name: 'find', params: { query: this.searchQ } })
        },
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

img.rounded-circle.profile-photo {
    border: 1px solid #e3e3e3;
    min-height: 2rem;
    min-width: 2rem;
}

.profile-photo {
    height: 2rem;
}

.search-input {
    width: 500px;
    max-width: 100%;
    font-weight: 600;
    font-size: 1.1rem;
    border: 1px solid #e3e3e3 !important;
    border-radius: 1rem;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    height: 50px;
}

.search-input:valid,
.search-input:focus {
    background-color: white;
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

.dropdown-menu {
    right: -30px;
    left: auto;
}
</style>