import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  universities: []
}

// getters
export const getters = {
  universities: state => state.universities,
  getUniversityById: (state) => (id) => {
    return state.universities.find(university => university['uni-id'] === Number(id))
  }
}

// mutations
export const mutations = {
  [types.ADD_UNIVERSITY](state, { university }) {
    state.universities.push(university)
  }
}

// actions
export const actions = {
  async fetchUniversity({ commit }, input) {
    if (state.universities.filter(function (e) { return e['uni-id'] === Number(input); }).length === 0) {
      try {
        const { data } = await axios.get('/api/v1/universities/' + input)
        commit(types.ADD_UNIVERSITY, { university: data })
      } catch (e) {
        console.log(e)
      }
    }
  },
  addUniversity({ commit }, data) {
    if (state.universities.filter(function (e) { return e['uni-id'] === data['uni-id']; }).length === 0) {
      try {
        commit(types.ADD_UNIVERSITY, { university: data })
      } catch (e) {
        console.log(e)
      }
    }
  }
}
