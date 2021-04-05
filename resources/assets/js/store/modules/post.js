import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  posts: []
}

// getters
export const getters = {
  posts: state => state.posts,
  getPostById: (state) => (id) => {
    return state.posts.find(post => post['post-id'] === Number(id))
  }
}

// mutations
export const mutations = {
  [types.ADD_POST](state, { post }) {
    state.posts.push(post)
  },
  [types.UPDATE_POST](state, { post }) {
    state.posts.set(post)
  }
}

// actions
export const actions = {
  async fetchPost({ commit }, input) {
    if (state.posts.filter(function (e) { return e['post-id'] === input; }).length === 0) {
      try {
        const { data } = await axios.get('/api/v1/posts/' + input)
        commit(types.ADD_POST, { post: data })
      } catch (e) {
        console.log(e)
      }
    }
  },
  addPost({ commit }, data) {
    if (state.posts.filter(function (e) { return e['post-id'] === data['post-id']; }).length === 0) {
      try {
        commit(types.ADD_POST, { post: data })
      } catch (e) {
        console.log(e)
      }
    }
  },
  updatePost({ commit }, payload) {
    commit(types.UPDATE_POST, payload)
  }
}
