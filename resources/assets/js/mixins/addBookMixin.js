import API from '../api/general'

export default {

    methods: {
        getSuggestions(type, arrayToPushInto = null, dispatchTo = null) {
            //?university=' + this.user['uni-id']
            API.show('suggestions', type).then((response) => {
                API.parseResponseData(this, response.data.data, arrayToPushInto ?? type)
            }).catch((e) => {
                console.log(e)
            })
        },
    }
}
