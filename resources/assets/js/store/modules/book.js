import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
    books: []
}

// getters
export const getters = {
    books: state => state.books,
    getBookByIsbn: (state) => (isbn) => {
        return state.books.find(book => book.isbn === isbn)
    }
}

// mutations
export const mutations = {
    [types.ADD_BOOK](state, { book }) {
        state.books.push(book)
    }
}

// actions
export const actions = {
    async fetchBook({ commit }, input) {
        if (state.books.filter(function(e) { return e.isbn === input; }).length === 0) {
            try {
                const { data } = await axios.get('/api/v1/books/' + input)
                commit(types.ADD_BOOK, { book: data })
            } catch (e) {
                await axios('/api/v1/books/' + input + '/google?save=true').then(response => {

                    if (response.data.isbn) {
                        commit(types.ADD_BOOK, { book: response.data })
                    }
                })
                return e;
            }
        }
        axios.post('/api/v1/textbooks/' + input + '/views')
    },
    addBook({ commit }, data) {
        if (state.books.filter(function(e) { return e.isbn === data.isbn; }).length === 0) {
            try {
                commit(types.ADD_BOOK, { book: data })
            } catch (e) {}
        }
    }
}