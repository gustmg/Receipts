export default {
    namespaced: true,

    state: {
        inventoryEntries: [],
        todayInventoryEntries: [],
        productsToEntry: [],
        productsEntryDetail: [],
        current_inventory_entry_detail: null,
    },

    getters: {
        getInventoryEntries: state => {
            return state.inventoryEntries
        },

        getTodayInventoryEntries: state => {
            return state.todayInventoryEntries
        },

        getProductsToEntry: state => {
            return state.productsToEntry
        },

        getProductsEntryDetail: state => {
            return state.productsEntryDetail
        },
    },

    mutations: {
        SET_INVENTORY_ENTRIES(state, inventoryEntries) {
            state.inventoryEntries = inventoryEntries
        },

        SET_TODAY_INVENTORY_ENTRIES(state, inventoryEntries) {
            state.todayInventoryEntries = inventoryEntries
        },

        SET_PRODUCTS_TO_ENTRY(state, products) {
            if (state.productsToEntry.length == 0) {
                state.productsToEntry = products

                products.forEach(product => {
                    var productEntry = {
                        product_id: product.product_id,
                        product_code: product.product_code,
                        product_name: product.product_name,
                        product_description: product.product_description,
                        product_amount: 0,
                        product_unit_cost: 0.0,
                        product_import: 0,
                    }
                    state.productsEntryDetail.push(productEntry)
                })
            } else {
                products.forEach(product => {
                    //Por cada producto que se desea agregar
                    var isInList = 0

                    state.productsToEntry.forEach(product_to_entry => {
                        if (product_to_entry.product_id == product.product_id) {
                            isInList++
                        }
                    })

                    if (isInList == 0) {
                        state.productsToEntry.push(product)
                        var productEntry = {
                            product_id: product.product_id,
                            product_code: product.product_code,
                            product_name: product.product_name,
                            product_description: product.product_description,
                            product_amount: 0,
                            product_unit_cost: 0.0,
                        }
                        state.productsEntryDetail.push(productEntry)
                    }
                })
            }
        },

        RESET_PRODUCTS_TO_ENTRY(state) {
            state.productsToEntry = []
        },

        RESET_PRODUCTS_TO_ENTRY_DETAIL(state) {
            state.productsEntryDetail = []
        },

        SET_CURRENT_INVENTORY_ENTRY_DETAIL(state, inventoryEntryId) {
            var index = state.inventoryEntries.findIndex(
                state_inventory_entry => state_inventory_entry.inventory_entry_id === inventoryEntryId
            )
            state.current_inventory_entry_detail = state.inventoryEntries[index]
        },

        RESET_INVENTORY_ENTRY_MODAL(state) {
            state.productsToEntry = []
            state.productsEntryDetail = []
        },
    },

    actions: {
        fetchInventoryEntries: function({ commit }) {
            axios
                .get('/inventory_entries')
                .then(response => {
                    commit('SET_INVENTORY_ENTRIES', response.data.inventory_entries)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        fetchTodayInventoryEntries: async function({ commit }) {
            await axios
                .post('fetchTodayInventoryEntries')
                .then(response => {
                    commit('SET_TODAY_INVENTORY_ENTRIES', response.data.inventory_entries)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        addInventoryEntry: function({ commit, dispatch }, inventory_entry_total_cost) {
            axios
                .post('/inventory_entries', {
                    inventory_entry_total_cost: inventory_entry_total_cost,
                })
                .then(function(response) {
                    dispatch('addInventoryEntryProducts')
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        addInventoryEntryProducts: function(context) {
            axios
                .post('/inventory_entries_products', {
                    products_entry_detail: context.state.productsEntryDetail,
                })
                .then(function(response) {
                    context.dispatch('fetchInventoryEntries')
                    context.commit('RESET_INVENTORY_ENTRY_MODAL')
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        setProductsToEntry: function({ commit }, products) {
            commit('SET_PRODUCTS_TO_ENTRY', products)
        },

        setCurrentInventoryEntryDetail: function({ commit }, inventoryEntryId) {
            commit('SET_CURRENT_INVENTORY_ENTRY_DETAIL', inventoryEntryId)
        },
    },
}
