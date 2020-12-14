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

        ADD_PRODUCT(state, product) {
            state.products.push(product)
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

        saveProduct: function({ commit }, product) {
            axios
                .post('/products', {
                    product_name: product.product_name,
                    product_description: product.product_description,
                    product_code: product.product_code,
                })
                .then(response => {
                    commit('ADD_PRODUCT', response.data.product)
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
