export default {
    namespaced: true,

    state: {
        receipts: [],
        serviceStatusList: [],
        todayReceipts: [],
        searchReceiptValue: '',
        lastReceiptId: 0,
        receiptClientId: null,
        receiptClientName: '',
        receiptClientPhone: '',
        receiptClientEmail: '',
    },

    getters: {
        getReceipts: state => {
            return state.receipts
        },

        getTodayReceipts: state => {
            return state.todayReceipts
        },

        getSearchReceiptValue: state => {
            return state.searchReceiptValue
        },

        getCurrentReceiptId: state => {
            return state.lastReceiptId + 1
        },

        getReceiptClientId: state => {
            return state.receiptClientId
        },

        getReceiptClientName: state => {
            return state.receiptClientName
        },

        getReceiptClientPhone: state => {
            return state.receiptClientPhone
        },

        getReceiptClientEmail: state => {
            return state.receiptClientEmail
        },

        getServiceStatusList: state => {
            return state.serviceStatusList
        },
    },

    mutations: {
        SET_RECEIPTS(state, receipts) {
            state.receipts = receipts
        },

        SET_TODAY_RECEIPTS(state, receipts) {
            state.todayReceipts = receipts
        },

        SET_LAST_RECEIPT_ID(state, lastReceiptId) {
            state.lastReceiptId = lastReceiptId
        },

        SET_SEARCH_RECEIPT_VALUE(state, updateSearchReceiptValue) {
            state.searchReceiptValue = updateSearchReceiptValue
        },

        SET_RECEIPT_CLIENT_ID(state, clientId) {
            state.receiptClientId = clientId
        },

        SET_RECEIPT_CLIENT_NAME(state, clientName) {
            state.receiptClientName = clientName
        },

        SET_RECEIPT_CLIENT_PHONE(state, clientPhone) {
            state.receiptClientPhone = clientPhone
        },

        SET_RECEIPT_CLIENT_EMAIL(state, clientEmail) {
            state.receiptClientEmail = clientEmail
        },

        SET_SERVICE_STATUS_LIST(state, serviceStatusList) {
            state.serviceStatusList = serviceStatusList
        },
    },

    actions: {
        fetchReceipts: async function({ commit }) {
            await axios
                .post('fetchReceipts')
                .then(response => {
                    commit('SET_RECEIPTS', response.data.receipts)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        fetchServiceStatusList: function({ commit }) {
            axios
                .post('fetchServiceStatusList')
                .then(response => {
                    commit('SET_SERVICE_STATUS_LIST', response.data.service_status_list)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        fetchTodayReceipts: async function({ commit }) {
            await axios
                .post('fetchTodayReceipts')
                .then(response => {
                    commit('SET_TODAY_RECEIPTS', response.data.receipts)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        fetchLastReceiptId: function({ commit }) {
            axios
                .post('fetchLastReceiptId')
                .then(response => {
                    commit('SET_LAST_RECEIPT_ID', response.data.last_receipt_id)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        saveReceipt: async function(context) {
            console.log('Guardando recepción...')
            try {
                await axios.post('receipts', { receipt_client_id: context.state.receiptClientId })
                console.log('Recepción guardada...OK')
            } catch (error) {
                console.log(error)
            }
        },

        printReceipt: async function(context, receiptId) {
            try {
                await axios.post('print_receipt', {
                    receipt_id: receiptId,
                })
            } catch (error) {
                console.log(error)
            }
        },
    },
}
