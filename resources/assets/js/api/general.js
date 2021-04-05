import axios from 'axios'

const apiVersion = '/api/v1/'

export default {
    index(endpoint, params) {
        return axios.get(apiVersion + endpoint, {
            params: params
        })
    },

    show(endpoint, id = null) {
        return axios.get(apiVersion + endpoint + (id !== null ? ('/' + id) : ''))
    },

    update(endpoint, id, data) {
        return axios.put(apiVersion + endpoint + '/' + id, data)
    },

    create(endpoint, data = null) {
        return axios.post(apiVersion + endpoint + '/', data)
    },

    delete(endpoint, id) {
        return axios.delete(apiVersion + endpoint + '/' + id)
    },
    parseResponseData(that, responseData, arrayToPushInto = null, dispatchTo = 'book/addBook') {
        if (!responseData || responseData.length === 0) {
            return
        }
        if (arrayToPushInto) {
            that[arrayToPushInto] = that[arrayToPushInto].concat(responseData)
        }
        if (dispatchTo) {
            responseData.forEach(item => {
                that.$store.dispatch((dispatchTo), item)
            })
        }
    }
}
