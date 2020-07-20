export default {
    namespaced: true,

    state: {
        products: [],
        searchProductValue: '',
    },

    getters: {
        getProducts: state => {
            return state.products
        },

        getSearchProductValue: state => {
            return state.searchProductValue
        },
    },

    mutations: {
        SET_PRODUCTS(state, products) {
            state.products = products
        },

        UPDATE_SEARCH_PRODUCT_VALUE(state, updateSearchProductValue) {
            state.searchProductValue = updateSearchProductValue
        },
    },

    actions: {
        fetchProducts: function({ commit }) {
            axios
                .post('fetchProducts')
                .then(response => {
                    commit('SET_PRODUCTS', response.data.products)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        updateSearchProductValue: function({ commit }, updateSearchProductValue) {
            commit('UPDATE_SEARCH_PRODUCT_VALUE', updateSearchProductValue)
        },
    },
}
