import inventoryEntries from './modules/inventoryEntries'
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
        product_to_update: {},
        product_to_update_prev_cost: 0,
        opened_modals: [],
        current_username: '',
    },

    mutations: {
        SET_CURRENT_USERNAME(state, username) {
            state.current_username = username
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

        UPDATE_PRODUCT_AMOUNT(state, newProductAmount) {
            state.products_entry_detail[newProductAmount.product_index].product_amount = newProductAmount.newValue
        },

        UPDATE_PRODUCT_UNIT_COST(state, newProductUnitCost) {
            state.products_entry_detail[newProductUnitCost.product_index].product_unit_cost =
                newProductUnitCost.new_unit_cost
        },
    },

    actions: {
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

        updateProductAmount: function({ commit }, newProductAmount) {
            commit('UPDATE_PRODUCT_AMOUNT', newProductAmount)
        },

        updateProductUnitCost: function({ commit }, newProductUnitCost) {
            commit('UPDATE_PRODUCT_UNIT_COST', newProductUnitCost)
        },
    },

    modules: {
        inventoryEntries,
        inventoryExits,
        services,
        sales,
        products,
        clients,
        receipts,
        devices,
        accessories,
    },
}
