import inventoryExits from './modules/inventoryExits'
import services from './modules/services'
import sales from './modules/sales'
import products from './modules/products'
import clients from './modules/clients'
import receipts from './modules/receipts'
import devices from './modules/devices'
import accessories from './modules/accessories'

export default {
    state: {
        products: [],
        inventory_entries: [],
        product_to_update: {},
        product_to_update_prev_cost: 0,
        opened_modals: [],
        current_username: '',
        products_to_entry: [],
        products_entry_detail: [],
        current_inventory_entry_detail: null,
        searchProductValue: '',
    },

    mutations: {
        SET_CURRENT_USERNAME(state, username) {
            state.current_username = username
        },
        SET_PRODUCTS(state, products) {
            state.products = products
        },
        SET_INVENTORY_ENTRIES(state, inventory_entries) {
            state.inventory_entries = inventory_entries
        },
        ADD_PRODUCT(state, product) {
            state.products.push(product)
        },
        UPDATE_PRODUCT(state, product) {
            var index = state.products.findIndex(state_product => state_product.product_id === product.product_id)
            state.products[index].product_name = product.product_name
            state.products[index].product_description = product.product_description
            state.products[index].product_code = product.product_code
            state.products[index].product_cost = product.product_cost
            state.products[index].product_base_price_percentage = product.product_base_price_percentage
            state.products[index].product_retail_price_percentage = product.product_retail_price_percentage
            state.products[index].product_wholesale_price_percentage = product.product_wholesale_price_percentage
        },
        SET_PRODUCT_TO_UPDATE(state, product) {
            state.product_to_update = product
            state.product_to_update_prev_cost = product.product_cost
        },
        OPEN_MODAL(state, modal) {
            var modal = M.Modal.getInstance(modal)
            state.opened_modals.push(modal)
            modal.open()
        },
        CLOSE_MODAL(state) {
            state.opened_modals[state.opened_modals.length - 1].close()
        },

        SET_PRODUCTS_TO_ENTRY(state, products) {
            if (state.products_to_entry.length == 0) {
                state.products_to_entry = products

                products.forEach(product => {
                    var productEntry = {
                        product_id: product.product_id,
                        checked: false,
                        product_amount: null,
                        product_unit_cost: null,
                    }
                    state.products_entry_detail.push(productEntry)
                })
            } else {
                products.forEach(product => {
                    //Por cada producto que se desea agregar
                    var isInList = 0

                    state.products_to_entry.forEach(product_to_entry => {
                        if (product_to_entry.product_id == product.product_id) {
                            isInList++
                        }
                    })

                    if (isInList == 0) {
                        state.products_to_entry.push(product)
                        var productEntry = {
                            product_id: product.product_id,
                            checked: false,
                            product_amount: null,
                            product_unit_cost: null,
                        }
                        state.products_entry_detail.push(productEntry)
                    }
                })
            }
        },

        UPDATE_PRODUCT_AMOUNT(state, newProductAmount) {
            state.products_entry_detail[newProductAmount.product_index].product_amount = newProductAmount.newValue
        },

        UPDATE_PRODUCT_UNIT_COST(state, newProductUnitCost) {
            state.products_entry_detail[newProductUnitCost.product_index].product_unit_cost =
                newProductUnitCost.new_unit_cost
        },

        SET_CURRENT_INVENTORY_ENTRY_DETAIL(state, inventoryEntryId) {
            var index = state.inventory_entries.findIndex(
                state_inventory_entry => state_inventory_entry.inventory_entry_id === inventoryEntryId
            )
            state.current_inventory_entry_detail = state.inventory_entries[index]
        },

        UPDATE_SEARCH_PRODUCT_VALUE(state, updateSearchProductValue) {
            state.searchProductValue = updateSearchProductValue
        },

        RESET_INVENTORY_ENTRY_MODAL(state) {
            state.products_to_entry = []
            state.products_entry_detail = []
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

        addProduct: function({ commit }, product) {
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
                    products_entry_detail: context.state.products_entry_detail,
                })
                .then(function(response) {
                    context.dispatch('fetchInventoryEntries')
                    context.commit('RESET_INVENTORY_ENTRY_MODAL')
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        updateProduct: function({ dispatch }, product) {
            axios
                .put('/products/' + product.product_id, {
                    product_name: product.product_name,
                    product_description: product.product_description,
                    product_code: product.product_code,
                    product_cost: product.product_cost,
                    product_base_price_percentage: product.product_base_price_percentage,
                    product_retail_price_percentage: product.product_retail_price_percentage,
                    product_wholesale_price_percentage: product.product_wholesale_price_percentage,
                })
                .then(response => {
                    commit('UPDATE_PRODUCT', response.data.product)
                })
                .catch(function(err) {
                    console.log(err)
                })
        },

        setProductToUpdate: function({ commit }, product) {
            var product_to_update = _.cloneDeep(product)
            commit('SET_PRODUCT_TO_UPDATE', product_to_update)
        },

        openModal: function({ commit }, modal) {
            commit('OPEN_MODAL', modal)
        },

        closeModal: function({ commit }) {
            commit('CLOSE_MODAL')
        },

        setCurrentUsername: function({ commit }, username) {
            commit('SET_CURRENT_USERNAME', username)
        },

        setProductsToEntry: function({ commit }, products) {
            commit('SET_PRODUCTS_TO_ENTRY', products)
        },

        updateProductAmount: function({ commit }, newProductAmount) {
            commit('UPDATE_PRODUCT_AMOUNT', newProductAmount)
        },

        updateProductUnitCost: function({ commit }, newProductUnitCost) {
            commit('UPDATE_PRODUCT_UNIT_COST', newProductUnitCost)
        },

        setCurrentInventoryEntryDetail: function({ commit }, inventoryEntryId) {
            commit('SET_CURRENT_INVENTORY_ENTRY_DETAIL', inventoryEntryId)
        },

        updateSearchProductValue: function({ commit }, updateSearchProductValue) {
            commit('UPDATE_SEARCH_PRODUCT_VALUE', updateSearchProductValue)
        },
    },

    modules: {
        inventoryExits: inventoryExits,
        services,
        sales,
        products,
        clients,
        receipts,
        devices,
        accessories,
    },
}
