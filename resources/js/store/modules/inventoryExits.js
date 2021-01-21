export default {
    namespaced: true,

    state: {
        inventoryExits: [],
        todayInventoryExits: [],
        productsToExit: [],
        productsExitDetail: [],
        current_inventory_exit_detail: null,
    },

    getters: {
        getInventoryExits: state => {
            return state.inventoryExits
        },

        getTodayInventoryExits: state => {
            return state.todayInventoryExits
        },

        getProductsToExit: state => {
            return state.productsToExit
        },

        getProductsExitDetail: state => {
            return state.productsExitDetail
        },
    },

    mutations: {
        SET_INVENTORY_EXITS(state, inventoryExits) {
            state.inventoryExits = inventoryExits
        },

        SET_TODAY_INVENTORY_EXITS(state, inventoryExits) {
            state.todayInventoryExits = inventoryExits
        },

        SET_PRODUCTS_TO_EXIT(state, products) {
            if (state.productsToExit.length == 0) {
                state.productsToExit = products

                products.forEach(product => {
                    var productExit = {
                        product_id: product.product_id,
                        product_code: product.product_code,
                        product_name: product.product_name,
                        product_description: product.product_description,
                        product_amount: 0,
                        product_justification: '',
                    }
                    state.productsExitDetail.push(productExit)
                })
            } else {
                products.forEach(product => {
                    //Por cada producto que se desea agregar
                    var isInList = 0

                    state.productsToExit.forEach(product_to_exit => {
                        if (product_to_exit.product_id == product.product_id) {
                            isInList++
                        }
                    })

                    if (isInList == 0) {
                        state.productsToExit.push(product)
                        var productExit = {
                            product_id: product.product_id,
                            product_code: product.product_code,
                            product_name: product.product_name,
                            product_description: product.product_description,
                            product_amount: 0,
                            product_justification: '',
                        }
                        state.productsExitDetail.push(productExit)
                    }
                })
            }
        },

        RESET_PRODUCTS_TO_EXIT(state) {
            state.productsToExit = []
        },

        RESET_PRODUCTS_TO_EXIT_DETAIL(state) {
            state.productsExitDetail = []
        },

        SET_CURRENT_INVENTORY_EXIT_DETAIL(state, inventoryExitId) {
            var index = state.inventoryExits.findIndex(
                state_inventory_exit => state_inventory_exit.inventory_exit_id === inventoryExitId
            )
            state.current_inventory_exit_detail = state.inventoryExits[index]
        },

        RESET_INVENTORY_EXIT_MODAL(state) {
            state.productsToExit = []
            state.productsExitDetail = []
        },
    },

    actions: {
        fetchInventoryExits: function({ commit }) {
            axios
                .get('/inventory_exits')
                .then(response => {
                    commit('SET_INVENTORY_EXITS', response.data.inventory_exits)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        fetchTodayInventoryExits: async function({ commit }) {
            await axios
                .post('fetchTodayInventoryExits')
                .then(response => {
                    commit('SET_TODAY_INVENTORY_EXITS', response.data.inventory_exits)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        addInventoryExit: function({ commit, dispatch }) {
            axios
                .post('/inventory_exits')
                .then(function(response) {
                    dispatch('addInventoryExitProducts')
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        addInventoryExitProducts: function(context) {
            axios
                .post('/inventory_exits_products', {
                    products_exit_detail: context.state.productsExitDetail,
                })
                .then(function(response) {
                    context.dispatch('fetchInventoryExits')
                    context.commit('RESET_INVENTORY_EXIT_MODAL')
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        setProductsToExit: function({ commit }, products) {
            commit('SET_PRODUCTS_TO_EXIT', products)
        },

        setCurrentInventoryExitDetail: function({ commit }, inventoryExitId) {
            commit('SET_CURRENT_INVENTORY_EXIT_DETAIL', inventoryExitId)
        },
    },
}
