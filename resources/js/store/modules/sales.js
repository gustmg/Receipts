export default {
    namespaced: true,

    state: {
        lastSaleId: 0,
        cart: [],
        saleClientId: null,
        saleClientName: '',
        saleClientPhone: '',
        saleClientEmail: '',
        salePaymentForm: 1,
        isInvoicedSale: 0,
        saleSubtotalAmount: 0,
        saleVatAmount: 0,
        saleCreditCardCharge: 0,
        saleTotalAmount: 0,
    },

    getters: {
        getCurrentSaleId: state => {
            return state.lastSaleId + 1
        },

        getCart: state => {
            return state.cart
        },

        getSaleClientId: state => {
            return state.saleClientId
        },

        getSaleClientName: state => {
            return state.saleClientName
        },

        getSaleClientPhone: state => {
            return state.saleClientPhone
        },

        getSaleClientEmail: state => {
            return state.saleClientEmail
        },

        getSalePaymentForm: state => {
            return state.salePaymentForm
        },

        getSaleSubtotalAmount: state => {
            state.saleSubtotalAmount = 0
            state.cart.forEach(cartItem => {
                state.saleSubtotalAmount += cartItem.articleAmount * cartItem.articleUnitPrice
            })
            return state.saleSubtotalAmount
        },

        getSaleVatAmount: state => {
            state.saleVatAmount = 0
            if (state.isInvoicedSale) {
                state.saleVatAmount = state.saleSubtotalAmount * 0.16
            }
            return state.saleVatAmount
        },

        getIsInvoicedSale: state => {
            return state.isInvoicedSale
        },

        getSaleCreditCardCharge: state => {
            state.saleCreditCardCharge = 0
            if (state.salePaymentForm == 2) {
                if (state.saleSubtotalAmount + state.saleVatAmount >= 1000) {
                    if (state.isInvoicedSale) {
                        state.saleCreditCardCharge = (state.saleSubtotalAmount + state.saleVatAmount) * 0.025
                    } else {
                        state.saleCreditCardCharge = state.saleSubtotalAmount * 0.025
                    }
                }
            }
            return state.saleCreditCardCharge
        },

        getSaleTotalAmount: state => {
            state.saleTotalAmount = 0
            state.saleTotalAmount = state.saleSubtotalAmount + state.saleVatAmount + state.saleCreditCardCharge
            return state.saleTotalAmount
        },

        getCart: state => {
            return state.cart
        },
    },

    mutations: {
        SET_LAST_SALE_ID(state, lastSaleId) {
            state.lastSaleId = lastSaleId
        },

        ADD_TO_CART(state, article) {
            state.cart.push(article)
        },

        SET_SALE_CLIENT_ID(state, clientId) {
            state.saleClientId = clientId
        },

        SET_SALE_CLIENT_NAME(state, clientName) {
            state.saleClientName = clientName
        },

        SET_SALE_CLIENT_PHONE(state, clientPhone) {
            state.saleClientPhone = clientPhone
        },

        SET_SALE_CLIENT_EMAIL(state, clientEmail) {
            state.saleClientEmail = clientEmail
        },

        SET_SALE_PAYMENT_FORM(state, paymentForm) {
            state.salePaymentForm = paymentForm
        },

        SET_INVOICED_SALE(state, isInvoicedSale) {
            state.isInvoicedSale = isInvoicedSale
        },
    },

    actions: {
        fetchLastSaleId: function({ commit }) {
            axios
                .post('fetchLastSaleId')
                .then(response => {
                    commit('SET_LAST_SALE_ID', response.data.last_sale_id)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        saveSale: async function(context) {
            try {
                await axios.post('sales', {
                    sale_client_id: context.state.saleClientId,
                    sale_payment_form_id: context.state.salePaymentForm,
                    sale_invoiced: context.state.isInvoicedSale,
                    sale_total_amount: context.state.saleTotalAmount,
                })
            } catch (error) {
                console.log(error)
            }
        },

        saveSaleDetail: async function(context) {
            try {
                await Promise.all(
                    context.state.cart.map(async article => {
                        if (article.articleType == 0) {
                            let response = await axios.post('sales_services', {
                                sale_id: context.getters.getCurrentSaleId,
                                service_id: article.articleId,
                                service_quantity: article.articleAmount,
                                service_unit_price: article.articleUnitPrice,
                            })
                            return response
                        } else {
                            let response = await axios.post('sales_products', {
                                sale_id: context.getters.getCurrentSaleId,
                                product_id: article.articleId,
                                product_quantity: article.articleAmount,
                                product_unit_price: article.articleUnitPrice,
                            })
                            return response
                        }
                    })
                )
            } catch (error) {
                console.log(error)
            }
        },

        printSale: async function(context) {
            try {
                await axios.post('print', {
                    sale_id: context.getters.getCurrentSaleId,
                    tax: context.state.isInvoicedSale,
                    credit_card_charge: context.getters.getSaleCreditCardCharge,
                })
                context.state.cart = []
                context.state.salePaymentForm = 1
                context.state.isInvoicedSale = 0
                context.state.saleClientId = null
                context.state.saleClientName = ''
                context.state.saleClientPhone = ''
                context.state.saleClientEmail = ''
                context.state.lastSaleId += 1
            } catch (error) {
                console.log(error)
            }
        },
    },
}
