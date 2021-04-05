import API from '~/api/general'
import Cookies from 'js-cookie'
import swal from 'sweetalert2'
import { i18n } from '~/plugins/i18n'
import { analyticsMiddleware } from 'vue-analytics'

import * as types from '../mutation-types'

// state
export const state = {
    user: null,
    token: Cookies.get('laravel_token')
}

// plugins
export const plugins = [
    analyticsMiddleware
  ]

// getters
export const getters = {
    user: state => state.user,
    token: state => state.token,
    check: state => state.user !== null
}

// mutations
export const mutations = {
    [types.SAVE_TOKEN](state, { token }) {
        state.token = token
        Cookies.set('laravel_token', token, { expires: 365 })
    },

    [types.FETCH_USER_SUCCESS](state, { user }) {
        state.user = user
        Echo.private(`App.User.${state.user['user-id']}`)
            .listen('OrderCreated', (e) => {
                state.user.unread_orders++
                    console.log(e)
                const message = `${e.order.buyer.name} ${i18n.t('wants_to_meet')}`
                swal({
                        type: 'info',
                        title: i18n.t('you_have_a_new_order'),
                        text: message,
                        confirmButtonText: i18n.t('accept_order'),
                        cancelButtonText: i18n.t('decline'),
                        showCancelButton: true,
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        allowEnterKey: false
                    })
                    .then(async(result) => {
                        console.log(result);
                        if (result) {
                            await API.create('/api/v1/orders/' + e.order['connect-id'] + '/accept').then(() => {
                                swal(
                                    i18n.t('you_accepted_the_meeting'),
                                    `${e.order.buyer.name} ${i18n.t('has_been_informed').toLowerCase()}.`,
                                    'success'
                                )
                                state.user.unread_orders--
                            })
                        }
                    })
            })
    },

    [types.FETCH_USER_FAILURE](state) {
        state.token = null
        Cookies.remove('laravel_token')
    },

    [types.LOGOUT](state) {
        Echo.leave(`App.User.${state.user['user-id']}`);
        state.user = null
        state.token = null

        Cookies.remove('laravel_token')
    },

    [types.UPDATE_USER](state, { user }) {
        state.user = user
    }
}

// actions
export const actions = {
    saveToken({ commit }, payload) {
        commit(types.SAVE_TOKEN, payload)
    },

    async fetchUser({ commit }) {
        try {
            const { data } = await API.show('me')
            //console.log('hello')
            //Vue.$ga.set('userId', userId)
            commit(types.FETCH_USER_SUCCESS, {
                user: data,
                meta: {
                    analytics: [
                        ['set', 'userId', data['user-id']]
                    ]
                }
            })
        } catch (e) {
            commit(types.FETCH_USER_FAILURE)
        }
    },

    updateUser({ commit }, payload) {
        commit(types.UPDATE_USER, payload)
    },

    async logout({ commit }) {
        try {
            await API.create('logout')
        } catch (e) {
            console.log(e)
        }

        commit(types.LOGOUT)
    }
}