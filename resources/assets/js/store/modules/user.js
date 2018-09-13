import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  users: []
}

// getters
export const getters = {
  users: state => state.users,
  getUserById: (state) => (id) => {
    return state.users.find(user => user['user-id'] === Number(id))
  }
}

// mutations
export const mutations = {
  [types.ADD_USER] (state, { user }) {
    state.users.push(user)
  }
}

// actions
export const actions = {
  async fetchUser ({ commit }, input ) {
  	if(state.users.filter(function(e) { return e['user-id'] === Number(input); }).length === 0) {
	  	try {
	      const { data } = await axios.get('/api/v1/users/'+input)
	      commit(types.ADD_USER, { user: data } )
	    } catch (e) { }
    }
  },
  addUser ({ commit }, data ) {
  	if(state.users.filter(function(e) { return e['user-id'] === data['user-id']; }).length === 0) {
	  	try {
	      commit(types.ADD_USER, { user: data } )
	    } catch (e) { }
    }
  }
}
